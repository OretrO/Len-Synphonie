<x-layout.app>
    <div class="mx-auto max-w-xl">
        <div
            class="mt-7 bg-white border border-gray-200 rounded-xl shadow-2xs dark:bg-neutral-900 dark:border-neutral-700">
            <div class="p-4 sm:p-7">
                <div class="text-center">
                    <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Connexion</h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-neutral-400">
                        Pas encore inscrit ?
                        <a class="text-blue-600 decoration-2 hover:underline focus:outline-hidden focus:underline font-medium dark:text-blue-500"
                           href="{{route('register')}}">
                            Inscrivez-vous ici
                        </a>
                    </p>
                </div>

                @if (session('status'))
                    <div class="mt-4 text-sm text-green-600 dark:text-green-400">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="grid gap-y-4">
                        <!-- Form Group -->
                        <div>
                            <x-label class="mb-3 dark:text-white" for="email" :value="__('Adresse mail')"/>
                            <x-input id="email"
                                     class="block w-full"
                                     type="email" name="email" :value="old('email')" required autofocus/>
                            @error('email')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- End Form Group -->
                        <!-- Form Group -->
                        <div>
                            <div class="flex flex-wrap justify-between items-center gap-2 mb-3 ">
                                <x-label class="dark:text-white" for="password" :value="__('Mot de passe')"/>
                                <a class="inline-flex items-center gap-x-1 text-sm text-blue-600 decoration-2 hover:underline focus:outline-hidden focus:underline font-medium dark:text-blue-500"
                                   href="{{route('password.request')}}">Mot de passe oublié ?</a>
                            </div>

                            <x-input id="password"
                                     class="block w-full"
                                     type="password"
                                     name="password"
                                     required/>
                            @error('password')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- End Form Group -->

                        <!-- Checkbox -->
                        <div class="flex items-center">
                            <div class="flex">
                                <x-input id="remember"
                                         class="shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                         name="remember" type="checkbox" @checked(old('remember')) />
                            </div>
                            <div class="ms-3">
                                <x-label for="remember" class="dark:text-white">Rester connecté</x-label>
                            </div>
                        </div>


                        <button type="submit"
                                class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                            {{ __('Se connecter') }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-layout.app>
