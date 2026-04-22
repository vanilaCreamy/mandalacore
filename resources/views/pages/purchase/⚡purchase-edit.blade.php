<?php

use Livewire\Component;
use App\Models\BudgetPlan;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Vendor;
use App\Models\Material;
use App\Models\Menu;
use App\Enums\PurchaseStatus;

new class extends Component
{
    public $po;
    public $isEdit = false;

    public $date;
    public $menu_id;

    public $items = [];

    public $material_id;
    public $vendor_id;
    public $qty_display;
    public $price;
    // public $grand_total;

    public $display_unit;

    public function mount(PurchaseOrder $po)
    {
        $this->isEdit = true;
        $this->po = $po;

        $this->date = $po->date;
        $this->menu_id = $po->menu_id;

        foreach ($po->items as $item) {
            $material = $item->material;

            $this->items[] = [
                'id'            => $item->id, // penting untuk update
                'material_id'   => $material->id,
                'material_name' => $material->name,
                'display_unit'  => $material->display_unit,
                'vendor_id'     => $item->vendor_id,
                'vendor_name'   => $item->vendor?->name,
                'qty_display'   => $item->qty_display,
                'price'         => $item->price,
            ];
        }
    }


    public function getMenusProperty()
    {
        return Menu::orderBy('date')->get();
    }

    public function getMaterialsProperty()
    {
        return Material::orderBy('name')->get();
    }

    public function getVendorsProperty()
    {
        return Vendor::orderBy('name')->get();
    }

    public function getGrandTotalProperty()
    {
        return collect($this->items)->sum(
            fn ($item) => $item['qty_display'] * $item['price']
        );
    }

    protected function findBudgetPlan()
    {
        return BudgetPlan::where('start_date', '<=', $this->date)
            ->where('end_date', '>=', $this->date)
            ->first();
    }

    public function updatedMaterialId()
    {  
        $material = Material::find($this->material_id);
        if ($material) {
            $this->display_unit = $material->display_unit;
        } else {
            $this->display_unit = "...";
        }
    }

    public function addItem()
    {
        $this->validate([
            'material_id' => 'required',
            'vendor_id' => 'required',
            'qty_display' => 'required|numeric|min:0.1',
        ]);

        $material = Material::find($this->material_id);
        $vendor   = Vendor::find($this->vendor_id);

        $this->items[] = [
            'material_id'   => $material->id,
            'material_name' => $material->name,
            'display_unit'  => $material->display_unit,
            'vendor_id'     => $vendor->id,
            'vendor_name'   => $vendor->name,
            'qty_display'   => $this->qty_display,
            'price'         => $this->price ?? 0,
        ];

        $this->reset(['material_id', 'vendor_id', 'qty_display', 'price']);
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items); // reindex
    }

    public function generateMaterialFromMenu()
    {
        $menu = Menu::find($this->menu_id);

        if (!$menu) return;

        $materials = $menu->generateMaterialNeeds();

        foreach ($materials as $mat) {
            $material = Material::find($mat['material_id']);

            $this->items[] = [
                'material_id'   => $material->id,
                'material_name' => $material->name,
                'display_unit'  => $material->display_unit,
                'vendor_id'     => null,
                'vendor_name'   => null,
                'qty_display'   => $mat['total_display'],
                'price'         => 0,
            ];
        }
    }

    public function updatedItems()
    {
        // paksa Livewire refresh reactivity
        $this->items = array_values($this->items);
    }

    public function update()
    {
        $this->validate([
            'items' => 'required|array|min:1',
        ]);

        // Update total dulu
        $this->po->update([
            'grand_total' => $this->grand_total,
        ]);

        // Ambil semua ID item lama di DB
        $existingIds = $this->po->items()->pluck('id')->toArray();

        $keptIds = [];

        foreach ($this->items as $item) {

            // VALIDASI vendor
            if (!$item['vendor_id']) {
                $this->addError("items.vendor_id", "Vendor wajib dipilih");
                return;
            }

            // 🔵 ITEM LAMA → UPDATE
            if (isset($item['id'])) {

                PurchaseOrderItem::where('id', $item['id'])->update([
                    'vendor_id' => $item['vendor_id'],
                    'material_id' => $item['material_id'],
                    'qty_display' => $item['qty_display'],
                    'price' => $item['price'],
                ]);

                $keptIds[] = $item['id'];
            }

            // 🟢 ITEM BARU → CREATE
            else {
                $new = PurchaseOrderItem::create([
                    'purchase_order_id' => $this->po->id,
                    'vendor_id' => $item['vendor_id'],
                    'material_id' => $item['material_id'],
                    'qty_display' => $item['qty_display'],
                    'price' => $item['price'],
                ]);

                $keptIds[] = $new->id;
            }
        }

        // 🔴 ITEM YANG DIHAPUS DARI TABEL → DELETE DARI DB
        $toDelete = array_diff($existingIds, $keptIds);

        PurchaseOrderItem::whereIn('id', $toDelete)->delete();

        return redirect()->route('purchase.index');
    }

};
?>

<div class="space-y-6">

    <x-header title="Pembaruan Purchase Order" subtitle="Belanja bahan harian" separator />

    <x-card title="Informasi PO" separator>
        <div class="grid grid-cols-3 gap-4">
            <x-input type="date" label="Tanggal PO" wire:model="date" :disabled="$isEdit" />


            <x-select
                label="Referensi Menu (opsional)"
                :options="$this->menus->map(fn($m)=>['id'=>$m->id,'name'=>$m->name.' - '.$m->date])"
                wire:model.live="menu_id" placeholder="..." :disabled="$isEdit"
            />
            
            <x-slot:append>
                <x-button icon="o-beaker" class="join-item btn-primary" wire:click="generateMaterialFromMenu" />
            </x-slot:append>
        </div>
    </x-card>

    <x-form wire:submit="addItem" no-separator>
        <div class="grid grid-cols-4 gap-3">
            <x-select
                placeholder="Bahan"
                :options="$this->materials->map(fn($m)=>['id'=>$m->id,'name'=>$m->name])"
                wire:model.live="material_id"
            />

            <x-select
                placeholder="Vendor"
                :options="$this->vendors->map(fn($v)=>['id'=>$v->id,'name'=>$v->name])"
                wire:model="vendor_id"
            />

            <x-input type="number"
                placeholder="Kuantitas"
                wire:model="qty_display" suffix="{{ $this->display_unit ?? '...' }}"
            />
            
            <x-input type="number" placeholder="Harga" prefix="IDR" wire:model="price" />
        </div>
    
        <x-slot:actions>
            <x-button label="Tambah Bahan" class="btn-primary" type="submit" spinner="addItem" />
        </x-slot:actions>
    </x-form>

    <x-card title="Daftar Belanja" separator>
        <table class="table-fixed w-full text-sm border-separate border-spacing-y-2 border-spacing-x-2">
            <colgroup>
                <col class="w-4/12">
                <col class="w-3/12">
                <col class="w-2/12">
                <col class="w-2/12">
                <col class="w-1/12">
            </colgroup>
            <thead>
                <tr class="text-left">
                    <th>Bahan</th>
                    <th>Vendor</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $i => $item)
                <tr>
                    <td class="truncate">
                        {{ $item['material_name'] }}
                    </td>
                
                    <td>
                        <x-select
                            class="w-full"
                            :options="$this->vendors->map(fn($v)=>['id'=>$v->id,'name'=>$v->name])"
                            wire:model="items.{{ $i }}.vendor_id"
                            placeholder="Pilih vendor"
                        />
                    </td>
                
                    <td>
                        {{ $item['qty_display'] }}
                        <span class="text-gray-500">
                            {{ $item['display_unit'] }}
                        </span>
                    </td>
                
                    <td>
                        <x-input type="number"
                            class="w-full"
                            wire:model="items.{{ $i }}.price"
                            placeholder="Harga" />
                    </td>
                
                    <td class="text-center">
                        <x-button icon="o-trash"
                                  wire:click="removeItem({{ $i }})"
                                  class="btn-ghost btn-sm" />
                    </td>
                </tr>
                @endforeach

                    <tr class="border-t border-slate-200">
                        <td colspan="3" class="text-right font-semibold pr-4">
                        </td>
                        <td>
                            <h5 class="border border-slate-300 rounded-md w-full p-2 flex items-center">
                                <span class="border-r border-slate-300">
                                    IDR
                                </span>
                                <span class="text-right block w-full">
                                    {{ number_format($this->grand_total, 0, ',', '.') }}
                                </span>
                            </h5>
                        </td>
                    </tr>
            </tbody>
        </table>
    </x-card>   

    <div class="flex justify-end">
        <x-button label="Update PO" wire:click="update" class="btn-primary" />
    </div>
    
</div>
