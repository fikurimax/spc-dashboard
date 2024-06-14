<x-filament-panels::page>
    <div class="flex justify-between h-full">
        <h3>Dashboard</h3>
        <div id="fullscreen">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
            </svg>
        </div>
    </div>
    @livewire(\App\Filament\Widgets\DeviceStat::class)
    <script>
        /* Get the element you want displayed in fullscreen mode (a video in this example): */
        var elem = document.getElementById("fullscreen");

        /* When the openFullscreen() function is executed, open the video in fullscreen.
        Note that we must include prefixes for different browsers, as they don't support the requestFullscreen method yet */
        function openFullscreen() {
            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.webkitRequestFullscreen) {
                /* Safari */
                elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) {
                /* IE11 */
                elem.msRequestFullscreen();
            }
        }
    </script>
</x-filament-panels::page>