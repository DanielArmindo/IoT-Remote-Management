<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Change Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Select Profile') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Switch to the following types of profiles") }}
                            </p>


                        </header>

                        <form method="post" action="{{ route('profile.update.type') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')

                            <div>
                                <x-input-label for="type_user" :value="__('Type of User')" />
                                <select id="type_user" name="type_user" class="mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                                    <option value="V" {{ old('type_user', $user->type_user) === 'V' ? 'selected' : '' }}>Client</option>
                                    <option value="A" {{ old('type_user', $user->type_user) === 'A' ? 'selected' : '' }}>Admin</option>
                                    <option value="S" {{ old('type_user', $user->type_user) === 'S' ? 'selected' : '' }}>Storage Admin</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('type_user')" />
                            </div>

                            <div>
                                <p class="text-sm text-gray-600">
                                    <span class="text-sm text-gray-900">Current Profile: </span>
                                    @switch($user->type_user)
                                        @case('V')
                                          Client
                                          @break
                                          @case('A')
                                          Admin
                                          @break
                                          @case('S')
                                          Storage Admin
                                          @break
                                        @endcase

                                    @endswitch
                                </p>
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>

                                @if (session('status') === 'profile-updated')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600 text-success"
                                    >{{ __('Saved.') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
