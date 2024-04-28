<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Change Disclaimer Lines') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Change Lines') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Write the lines that will be shown in the disclaimer") }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('warehouse.disclaimer.update') }}" class="mt-6 space-y-6">
                            @csrf

                            <div>
                                <x-input-label for="line01" :value="__('Line 01')" />
                                <x-text-input id="line01" name="line01" type="text" class="mt-1 block w-full" :value="old('line01', $line01)" autofocus autocomplete="name" />
                            </div>

                            <div>
                                <x-input-label for="line02" :value="__('Line 02')" />
                                <x-text-input id="line02" name="line02" type="text" class="mt-1 block w-full" :value="old('line02', $line02)" autofocus autocomplete="name" />
                            </div>

                            <div>
                                <p class="text-sm text-gray-600">
                                    <span class="text-sm text-gray-900">1º Line: </span>
                                    {{$line01}}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="text-sm text-gray-900">2º Line: </span>
                                    {{$line02}}
                                </p>
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                                @if (session()->get('status'))
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 4000)"
                                        class="text-sm text-gray-600 {{preg_match('/Not Updated/', session()->get('status')) ? 'text-danger' : 'text-success'}}"
                                    >{{ session()->get('status') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
