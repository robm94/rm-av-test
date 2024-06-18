<x-layout>
    <div class="flex flex-col gap-4 lg:flex-row">
        <div class="flex-col w-full items-start rounded-lg ring-1 ring-zinc-500 bg-zinc-900">
            <p class="mt-6 text-center">Login to get your Kanye quotes</p>
            <form action="/login" method="POST" class="py-10 justify-center gap-y-4 grid grid-flow-row w-full">
                @csrf
                <div class="flex flex-col items-start md:inline-flex md:flex-row md:items-center">
                    <label for="email" class="flex-1 mr-4 mb-4 md:mb-0">Email</label>
                    <input type="email" id="email" name="email" class="w-64 p-2 rounded text-black" required autocomplete="username" />
                </div>
                @error('email')
                    <div class="contents text-red-600">{{ $message }}</div>
                @enderror
                
                <div class="flex flex-col items-start md:inline-flex md:flex-row md:items-center">
                    <label for="password" class="flex-1 mr-4 mb-4 md:mb-0">Password</label>
                    <input type="password" id="password" name="password" class="w-64 p-2 rounded text-black" required autocomplete="current-password" />
                </div>

                <input type="submit" class="bg-sky-600 rounded w-24 p-2 mt-6 justify-self-end" value="Login">
            </form>
        </div>
        
        <div class="flex-col w-full items-start rounded-lg ring-1 ring-zinc-500 bg-zinc-900">
            <p class="mt-6 text-center">Register Here</p>
            <form action="/register" method="POST" class="py-10 justify-center gap-y-4 grid grid-flow-row w-full">
                @csrf
                <div class="flex flex-col items-start md:inline-flex md:flex-row md:items-center">
                    <label for="reg_email" class="flex-1 mr-4 mb-4 md:mb-0">Email</label>
                    <input type="email" id="reg_email" name="email" class="w-64 p-2 rounded text-black" required autocomplete="username" />
                </div>
                @error('email')
                    <div class="contents text-red-600">{{ $message }}</div>
                @enderror
                
                <div class="flex flex-col items-start md:inline-flex md:flex-row md:items-center">
                    <label for="reg_password" class="flex-1 mr-4 mb-4 md:mb-0">Password</label>
                    <input type="password" id="reg_password" name="password" class="w-64 p-2 rounded text-black" required autocomplete="new-password"/>
                </div>
                @error('password')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror
                
                <div class="flex flex-col items-start md:inline-flex md:flex-row md:items-center">
                    <label for="reg_password_confirm" class="flex-1 mr-4 mb-4 md:mb-0">Confirm Password</label>
                    <input type="password" id="reg_password_confirm" name="password_confirmation" class="w-64 p-2 rounded text-black" required autocomplete="new-password"/>
                </div>
                @error('password_confirmation')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror

                <input type="submit" class="bg-sky-600 rounded w-24 p-2 mt-6 justify-self-end" value="Register">
            </form>
        </div>
    </div>
    
</x-layout>
