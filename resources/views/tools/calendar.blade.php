<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<!-- Add a modern font like Inter or Sans-serif -->
<style>
    :root { --fc-border-color: #e2e8f0; --fc-daygrid-dot-event-config-color: #3b82f6; }
    
    .calendar-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        margin-top: 20px;
    }

    /* Make event text readable */
    .fc-event-title { font-weight: 500; font-size: 0.85rem; padding: 2px; }
    
    /* Clean up the header buttons */
    .fc-button-primary {
        background-color: #4f46e5 !important;
        border-color: #4f46e5 !important;
        text-transform: capitalize;
    }
</style>

<div class="container mx-auto px-4">
    <div class="calendar-card">
        <div id="calendar"></div>
    </div>
</div>
  

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView: 'dayGridMonth',

        events: @json($events)
    });

    calendar.render();
});
</script>