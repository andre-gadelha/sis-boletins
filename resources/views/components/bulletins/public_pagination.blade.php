<!-- bulletins  -->
@isset($bulletins)
    @if (method_exists($bulletins, 'links'))
        <!-- bulletins  -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-3">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="mr-2 mt-2 mb-2 ml-3">
                    {{ $bulletins->links() }}
                </div>
            </div>
        </div>
    @endif
@endisset