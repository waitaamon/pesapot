<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Welcome <strong>{{ auth()->user()->name }}</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent overflow-hidden sm:rounded-lg">
                <div class="p-6 bg-transparent ">
                    <div>
                        <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">

                            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Total Cash Receipt
                                </dt>
                                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                                    {{ number_format($totalReceipt, 2) }}
                                </dd>
                            </div>

                            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Total Cash Payment
                                </dt>
                                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                                    {{ number_format($totalPayment, 2) }}
                                </dd>
                            </div>

                            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Cash At Hand
                                </dt>
                                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                                    {{ number_format($balance, 2) }}
                                </dd>
                            </div>

                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
