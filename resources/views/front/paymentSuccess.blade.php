<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment Successful - Dark Theme</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-200 min-h-screen flex items-center justify-center">
  <div class="max-w-4xl mx-auto bg-gray-800 shadow-lg rounded-lg p-8">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div class="flex items-center gap-2">
        <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center text-white">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414L8.414 15l-4.707-4.707a1 1 0 011.414-1.414L8.414 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
          </svg>
        </div>
        <h2 class="text-lg font-semibold text-gray-100">Almost there!</h2>
      </div>
      <button class="text-gray-400 hover:text-gray-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M10 9a1 1 0 000 2h6a1 1 0 000-2H10zM4 9a1 1 0 000 2h2a1 1 0 000-2H4z" clip-rule="evenodd" />
        </svg>
      </button>
    </div>

    <!-- Content -->
    <div class="mt-8 text-center">
      <h1 class="text-2xl font-bold text-gray-100">Payment successful</h1>
      <p class="text-gray-400 mt-2">Thank you for choosing Qetcil. Your artificial blooms are on their way!</p>
      <div class="flex items-center justify-center mt-6 space-x-4">
        <div class="flex items-center space-x-2">
          <div class="w-4 h-4 bg-green-500 rounded-full"></div>
          <span class="text-sm font-medium text-gray-200">Unpaid</span>
        </div>
        <div class="flex items-center space-x-2">
          <div class="w-4 h-4 bg-green-500 rounded-full"></div>
          <span class="text-sm font-medium text-gray-200">Payment received</span>
        </div>
        <div class="flex items-center space-x-2">
          <div class="w-4 h-4 bg-gray-600 rounded-full"></div>
          <span class="text-sm font-medium text-gray-400">Processing order</span>
        </div>
      </div>

      <div class="flex justify-center gap-4 mt-8">
        {{-- <a href="{{ route('front.index') }}" class="px-6 py-2 bg-green-500 text-white rounded-lg shadow hover:bg-green-600">New Site</a> --}}
        <a href="{{ route('front.index') }}" class="px-6 py-2 bg-gray-700 text-gray-200 rounded-lg shadow hover:bg-gray-600">Back Home</a>
      </div>

    </div>
  </div>
</body>
</html>
