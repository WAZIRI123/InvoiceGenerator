<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Template</title>
   @vite(['resources/css/app.css', 'resources/js/app.js']);
</head>
<body class="bg-gray-100 font-sans">
    @if (isset($Details))
        
<div class="h-full bg-gray-200 p-8">
                    <!-- start::Invoce 1 -->
                    <div class="w-[793px] h-[1122px] flex flex-col justify-between bg-white mx-auto shadow-xl mt-12 p-[72px]">
                        <div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-3xl tracking-wide">{{$Details['title']}}</p>
                                    <p class="text-xl font-bold tracking-wide mt-4">{{$Details['companyName']}}</p>
                                    <p class="text-sm text-gray-700">{{$Details['companyEmail']}}</p>
                                   
                                </div>
                                <div>
                                    <span class="bg-gray-400 text-2xl text-gray-100 px-3 py-6 rounded-full">logo</span>
                                </div>
                            </div>
                            <div class="bg-gray-400 w-full h-[1px] my-8"></div>
                            <div class="flex justify-between">
                                <div>
                                    <p class="font-bold">Invoice To:</p>
                                    <p class="text-gray-700 mt-2">{{$Details['customerName']}}</p>
                                   
                                </div>
                                <div class="flex flex-col space-y-1">
                                    <div class="flex items-center">
                                        <span class="w-32 font-bold">Invoice No.</span>
                                        <span class="text-gray-700">{{$Details['invoiceNumber']}}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="w-32 font-bold">Payment Date</span>
                                        <span class="text-gray-700">{{$Details['invoiceDate']}}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="w-32 font-bold">Due Date</span>
                                        <span class="text-gray-700">{{$Details['dueDate']}}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="w-32 font-bold">Amount (USD)</span>
                                        <span class="text-red-600 font-bold">Tsh {{$itemTotal}}=/ </span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-24">
                                <table class="w-full">
                                    <thead class="h-12 border-y-4 border-gray-500">
                                        <tr><th>#</th>
                                        <th>Item</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Amount</th>
                                    </tr></thead>
                                    <tbody>
                                        @foreach ($itemDetails as $itemDetails)
                                        <tr class="text-gray-700 text-center">
                                            <td class="py-2">1</td>
                                            <td>{{$itemDetails['name']}}</td>
                                            <td>{{$itemDetails['quantity']}}</td>
                                            <td>{{$itemDetails['price']}}</td>
                                            <td>{{$itemDetails['amount']}}</td>
                                        </tr>
                                        @endforeach
                                        <tr class="border-t-2">
                                            <td class="py-2" colspan="5"></td>
                                        </tr>
                                        <tr class="text-center">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="font-bold">Total</td>
                                            <td>Tsh {{$itemTotal}}=/</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="text-center text-xs text-gray-700">
                            <p>For questions concering this invoice, please contact</p>
                            <p>Waziri, 0653039317, wazirially1994@gmail.com</p>
                            <p>www.waziri.com</p>
                        </div>
                    </div>
                    <!-- end::Invoce 1 -->
                </div>
                @else
                make should you have set all details
                @endif
</body>


</html>
