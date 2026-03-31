import './bootstrap';
import { Calendar } from 'vanilla-calendar-pro';
import 'vanilla-calendar-pro/styles/index.css';

let calendarInstance = null;

window.initVanillaCalendar = (events = []) => {
    const el = document.querySelector('#calendar');
    if (!el) return;

    if (calendarInstance) {
        calendarInstance.destroy();
        calendarInstance = null;
    }

    // 🔥 transform events → popups
    const popups = {};

    events.forEach(e => {
        popups[e.date] = {
            modifier: e.css,   // tailwind class from PHP
            html: `
                <div class="text-left">
                    <div class="font-bold">${e.label}</div>
                    <div class="text-xs opacity-70">${e.date}</div>
                </div>
            `,
        };
    });

    calendarInstance = new Calendar(el, {
        locale: 'id-ID',
        firstWeekday: 0,
        selectedTheme: 'light',
        selectedWeekends: [],
        popups: popups,
    });

    calendarInstance.init();
};

// ✅ LISTEN HERE, NOT IN BLADE
document.addEventListener('livewire:navigated', () => {
    const el = document.querySelector('#calendar');
    if (!el) return;

    const events = JSON.parse(el.dataset.events || '[]');
    initVanillaCalendar(events);
});