<!-- bulletins  -->
@isset($users)
    @if (method_exists($users, 'links'))
        <!-- users  -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-3">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="mr-2 mt-2 mb-2 ml-3">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    @endif
@endisset