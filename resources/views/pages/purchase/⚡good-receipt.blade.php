<?php

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Material;
use App\Models\Vendor;
use App\Models\GoodReceipt;
use App\Models\GoodReceiptItem;
use App\Models\Inventory;

new class extends Component
{
    public $breadcrumbs;
    public $purchase_order;

    public $display_unit = '...';

    // form input
    public $material_id;
    public $vendor_id;
    public $qty_po = 0;
    public $qty_received;
    public $price;

    // list diterima
    public $receivedItems = [];

    public $previousReceipt = null;

    public function mount($id)
    {
        $this->purchase_order = PurchaseOrder::with('items')->findOrFail($id);

        // 🔥 Ambil histori penerimaan sebelumnya untuk PO ini
        // $this->previousReceipts = GoodReceiptItem::query()
        //     ->select(
        //         'materials.name as material_name',
        //         DB::raw('SUM(goods_receipt_items.qty_received) as total_received'),
        //         DB::raw('COUNT(goods_receipt_items.id) as total_times')
        //     )
        //     ->join('goods_receipts', 'goods_receipts.id', '=', 'goods_receipt_items.receipt_id')
        //     ->join('materials', 'materials.id', '=', 'goods_receipt_items.material_id')
        //     ->where('goods_receipts.po_id', $this->purchase_order->id)
        //     ->groupBy('materials.name')
        //     ->get()
        //     ->toArray();

        // 🔥 Ambil histori penerimaan sebelumnya untuk PO ini
        $this->previousReceipt = GoodReceipt::with([
            'items.material',
        ])
        ->where('po_id', $this->purchase_order->id)
        ->latest()
        ->get();


        $this->breadcrumbs = [ ['icon' => 'o-home', 'url' => route('dashboard')], ['label' => 'Purchase', 'url' => route('purchase.index')], ['label' => 'Good Receipt', 'url' => ''], ];
    }

    public function updatedMaterialId($value)
    {
        $poItem = PurchaseOrderItem::where('purchase_order_id', $this->purchase_order->id)
            ->where('material_id', $value)
            ->first();

        if ($poItem) {
            $this->vendor_id = $poItem->vendor_id;
            $this->qty_po    = $poItem->qty_display;
            $this->price     = $poItem->price;
            $this->display_unit = $poItem->material->display_unit;
        } else {
            $this->vendor_id = null;
            $this->qty_po    = 0;
            $this->price     = null;
            $this->display_unit = '...';
        }
    }

    public function addItem()
    {
        $material = Material::find($this->material_id);
        $vendor   = Vendor::find($this->vendor_id);

        $this->receivedItems[] = [
            'material_id'   => $this->material_id,
            'material_name' => $material->name,
            'vendor_id'     => $this->vendor_id,
            'vendor_name'   => $vendor->name,
            'qty_po'        => $this->qty_po,
            'qty_received'  => $this->qty_received,
            'price'         => $this->price,
            'subtotal'      => $this->qty_received * ($this->price ?? 0),
        ];

        // reset form
        $this->reset(['material_id','vendor_id','qty_po','qty_received','price']);
    }

    public function postReceipt()
    {
        DB::transaction(function () {

            $receipt = GoodReceipt::create([
                'po_id'        => $this->purchase_order->id,
                'receipt_date' => now(),
                'status'       => 'posted',
            ]);

            foreach ($this->receivedItems as $item) {

                $receiptItem = GoodReceiptItem::create([
                    'receipt_id'  => $receipt->id,
                    'material_id' => $item['material_id'],
                    'vendor_id'   => $item['vendor_id'],
                    'qty_ordered' => $item['qty_po'],
                    'qty_received'=> $item['qty_received'],
                    'price'       => $item['price'],
                    'subtotal'    => $item['subtotal'],
                ]);

                $balance = Material::find($item['material_id']);

                $newBalance = $balance->qty_gram + ($item['qty_received'] * $balance->conversion);
                $newPrice = $item['price'] ?? $balance->updated_price;

                Inventory::create([
                    'material_id' => $item['material_id'],
                    'ref_type'    => 'RECEIPT',
                    'ref_id'      => $receiptItem->id,
                    'date'        => now(),
                    'qty_in'      => $item['qty_received'],
                    'qty_out'     => 0,
                    'balance'     => $newBalance,
                ]);

                $balance->update([
                    'qty_gram' => $newBalance,
                    'updated_price' => $newPrice,
                ]);
            }
        });

        session()->flash('success', 'Stok berhasil masuk inventory.');
        // return redirect()->route('purchase.index');
    }
};
?>

<div>
    <x-breadcrumbs :items="$breadcrumbs" />

    <x-header title="Penerimaan Barang" subtitle="Input qty nyata yang datang">
        <x-slot:actions>
            <x-button link="{{ route('purchase.index') }}"
                      class="btn-dash"
                      icon="o-arrow-left"
                      label="Kembali" />
        </x-slot:actions>
    </x-header>

    @foreach ($previousReceipt as $receipt)
        <div class="relative pl-8 border-l">

            {{-- Titik timeline --}}
            <div class="absolute -left-[7px] top-2 w-3 h-3 rounded-full bg-primary"></div>

            {{-- Header receipt --}}
            <div class="mb-2">
                <div class="font-semibold">
                    Receipt #: {{ $receipt->code }}
                </div>
                <div class="text-xs text-gray-500">
                    {{ $receipt->created_at->format('d M Y H:i') }}
                    • Diterima oleh: {{ $receipt->createdBy->name ?? '-' }}
                </div>
            </div>

            {{-- Items dalam receipt --}}
            <div class="space-y-2">
                @foreach ($receipt->items as $item)
                    <div class="bg-base-200 rounded-lg p-3 text-sm">

                        <div class="font-medium">
                            {{ $item->material->name }}
                        </div>

                        <div class="grid grid-cols-2 gap-2 mt-1 text-gray-600">
                            <div>
                                📦 Qty Datang:
                                <b>{{ $item->qty }} {{ $item->qty_received }}</b>
                            </div>

                            <div>
                                💰 Harga:
                                Rp {{ number_format($item->price) }}
                            </div>

                            @if(isset($item->remaining))
                            <div>
                                🧮 Sisa PO setelah ini:
                                <b>{{ $item->remaining }} {{ $item->unit }}</b>
                            </div>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>

        </div>
    @endforeach


    <x-card title="Input Bahan Datang">
        <x-form wire:submit="addItem">
            <div class="grid grid-cols-12 gap-1">
                <div class="col-span-3">
                    <x-select label="Bahan" wire:model.live="material_id" :options="Material::all()->map(fn($material) => ['id' => $material->id, 'name' => $material->name])" placeholder="Pilih Bahan" />
                </div>

                <div class="col-span-3">
                    <x-select label="Vendo" wire:model="vendor_id" :options="Vendor::all()->map(fn($vendor) => ['id' => $vendor->id, 'name' => $vendor->name])" placeholder="Pilih Vendor" />
                </div>
                
                <div class="col-span-1">
                    <x-input label="Qty PO" wire:model="qty_po" disabled />
                </div>

                <div class="col-span-2">
                    <x-input label="Qty Datang" wire:model="qty_received" type="number" suffix="{{ $this->display_unit }}" />
                </div>

                <div class="col-span-3">
                    <x-input label="Harga" wire:model="price" type="number" />
                </div>                
            </div>
            <x-slot:actions>
                <x-button label="Terima" type="submit" class="btn-primary w-full" spinner="addItem" />
            </x-slot:actions>
        </x-form>
    </x-card>


    <x-card class="mt-6" title="Daftar Bahan Diterima">
        <table class="table w-full">
            <thead>
                <tr>
                    <th>Bahan</th>
                    <th>Vendor</th>
                    <th class="text-right">Qty PO</th>
                    <th class="text-right">Qty Datang</th>
                    <th class="text-right">Harga</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($receivedItems as $item)
                    <tr>
                        <td>{{ $item['material_name'] }}</td>
                        <td>{{ $item['vendor_name'] }}</td>
                        <td class="text-right">{{ $item['qty_po'] }}</td>
                        <td class="text-right">{{ $item['qty_received'] }}</td>
                        <td class="text-right">{{ number_format($item['price'] ?? 0,2) }}</td>
                        <td class="text-right">{{ number_format($item['subtotal'],2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="flex justify-end mt-4">
            <x-button label="Post & Masukkan Stok"
                    wire:click="postReceipt"
                    class="btn-primary" spinner="postReceipt" />
        </div>
    </x-card>

</div>
