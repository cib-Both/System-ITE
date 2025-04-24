<x-filament-panels::page>
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <!-- Invoice Header -->
        <div class="flex justify-between items-start mb-5">
            <div>
                <h1 class="text-2xl font-bold text-gray-700">Invoice</h1>
                <div class="mt-2 text-sm text-gray-500 space-y-1">
                    <p>Invoice No: <span class="font-medium text-gray-700">{{ $purchase->invoice_number }}</span></p>
                    <p>Purchase Date: <span class="font-medium text-gray-700">{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('M d, Y') }}</span></p>

                </div>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-700 mt-1">Supplier Details</h2>
                <div class="mt-2 text-sm text-gray-500 space-y-1">
                    <p>Name: <span class="font-medium text-gray-700">{{ $purchase->supplier->name }}</span></p>
                    <p>Email: <span class="font-medium text-gray-700">{{ $purchase->supplier->email }}</span></p>
                    <p>Phone: <span class="font-medium text-gray-700">{{ $purchase->supplier->phone }}</span></p>
                </div>
            </div>
        </div>

 <!-- Product Details Table -->
    <div class="border-t pt-4">
        <h2 class="text-xl font-bold text-gray-700 mb-4">Product Details</h2>
            <table class="w-full text-left border-collapse overflow-hidden border border-gray-800 ">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 border-b border-gray-300">
                        <th class="border border-black p-4 text-sm">Product Brand</th>
                        <th class="border border-black p-4 text-sm">Model</th>
                        <th class="border border-black p-4 text-sm">Serial Number</th>
                        <th class="border border-black p-4 text-sm">Price</th>
                        <th class="border border-black p-4 text-sm">Quantity</th>
                        <th class="border border-black p-4 text-sm">Total Price</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @if ($purchase->product)
                        @foreach ($purchase->product as $product)
                            <tr>
                                <td class="border border-gray-400 p-4 text-sm font-medium text-gray-700">{{ $product->product->brand }}</td>
                                <td class="border border-gray-400 p-4 text-sm font-medium text-gray-700">{{ $product->product->model }}</td>
                                <td class="border border-gray-400 p-4 text-sm font-medium text-gray-700">{{ $product->serial_number }}</td>
                                <td class="border border-gray-400 p-4 text-sm font-medium text-gray-700">${{ number_format($product->price, 2) }}</td>
                                <td class="border border-gray-400 p-4 text-sm font-medium text-gray-700 text-center">{{ $product->quantity }}</td>
                                <td class="border border-gray-400 p-4 text-sm font-medium text-gray-700">${{ number_format($product->quantity * $product->price, 2) }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="p-4 text-center text-sm text-gray-500">No products found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>


        <!-- Summary Table -->
        <div class="flex justify-end">
            <div class="w-1/2 p-6">
                <table class="w-full text-sm text-gray-700">
                    <tbody>
                        <tr class="border-b border-gray-300">
                            <td class="py-2 font-medium">Total Quantity:</td>
                            <td class="py-2 text-right font-bold text-xl">{{ $purchase->total_qty }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-medium">Total Cost:</td>
                            <td class="py-2 text-right font-bold text-xl">${{ number_format($purchase->total_cost, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-filament-panels::page>
