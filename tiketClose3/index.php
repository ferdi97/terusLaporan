<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ticket_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
```Here is the updated HTML content after applying above edits:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #10b981;
            --dark-color: #1e293b;
            --light-color: #f8fafc;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f1f5f9;
            color: var(--dark-color);
        }
        
        .card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: #4338ca;
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background-color: var(--secondary-color);
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            background-color: #0d9488;
            transform: translateY(-2px);
        }
        
        .form-input {
            transition: all 0.3s ease;
        }
        
        .form-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }
        
        .modal {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
        
        .modal-enter {
            opacity: 0;
            transform: scale(0.9);
        }
        
        .modal-enter-active {
            opacity: 1;
            transform: scale(1);
        }
        
        .drawer {
            transition: transform 0.3s ease;
        }
        
        .drawer-enter {
            transform: translateX(100%);
        }
        
        .drawer-enter-active {
            transform: translateX(0);
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(79, 70, 229, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(79, 70, 229, 0); }
            100% { box-shadow: 0 0 0 0 rgba(79, 70, 229, 0); }
        }
    </style>
</head>
<body class="min-h-screen">
    <!-- Header -->
    <header class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h1 class="text-2xl font-bold">Ticket Management</h1>
                </div>
                <div class="flex space-x-4">
                    <a href="ticket_list.html" class="text-white px-4 py-2 rounded-lg font-medium hover:bg-indigo-700 transition-all">View Tickets</a>
                    <button id="newCloseTicketBtn" class="bg-white text-indigo-600 px-4 py-2 rounded-lg font-medium hover:bg-indigo-50 transition-all flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Close Ticket
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Filter Section -->
        <div class="mb-8 bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Filter Tickets</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="filterStatus" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="filterStatus" class="w-full form-input rounded-lg border-gray-300">
                        <option value="">All Status</option>
                        <option value="PENDING">Pending</option>
                        <option value="CLOSE">Close</option>
                    </select>
                </div>
                <div>
                    <label for="filterNik" class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                    <input type="text" id="filterNik" class="w-full form-input rounded-lg border-gray-300" placeholder="Search by NIK">
                </div>
                <div>
                    <label for="filterTicket" class="block text-sm font-medium text-gray-700 mb-1">Ticket</label>
                    <input type="text" id="filterTicket" class="w-full form-input rounded-lg border-gray-300" placeholder="Search by Ticket">
                </div>
                <div class="flex items-end">
                    <button id="applyFilter" class="btn-primary text-white px-4 py-2 rounded-lg w-full">
                        Apply Filter
                    </button>
                </div>
            </div>
        </div>

        <!-- Ticket List -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ticket</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No INET</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">RFO</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="ticketList" class="bg-white divide-y divide-gray-200">
                        <!-- Sample Data (will be replaced by dynamic data) -->
                        <tr class="hover:bg-gray-50 fade-in">
                            <td class="px-6 py-4 whitespace-nowrap">1234567890</td>
                            <td class="px-6 py-4 whitespace-nowrap">TKT-20230001</td>
                            <td class="px-6 py-4 whitespace-nowrap">INET123456</td>
                            <td class="px-6 py-4 whitespace-nowrap">SAMBUНG</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">PENDING</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button class="view-btn text-indigo-600 hover:text-indigo-900 mr-3" data-id="1">View</button>
                                <button class="edit-btn text-green-600 hover:text-green-900 mr-3" data-id="1">Edit</button>
                                <button class="delete-btn text-red-600 hover:text-red-900" data-id="1">Delete</button>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 fade-in">
                            <td class="px-6 py-4 whitespace-nowrap">9876543210</td>
                            <td class="px-6 py-4 whitespace-nowrap">TKT-20230002</td>
                            <td class="px-6 py-4 whitespace-nowrap">INET654321</td>
                            <td class="px-6 py-4 whitespace-nowrap">CONFUL</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">CLOSE</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button class="view-btn text-indigo-600 hover:text-indigo-900 mr-3" data-id="2">View</button>
                                <button class="edit-btn text-green-600 hover:text-green-900 mr-3" data-id="2">Edit</button>
                                <button class="delete-btn text-red-600 hover:text-red-900" data-id="2">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="flex justify-between items-center mt-4">
            <div class="text-sm text-gray-700">
                Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">25</span> results
            </div>
            <div class="flex space-x-1">
                <button class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Previous</button>
                <button class="px-3 py-1 bg-indigo-600 text-white rounded">1</button>
                <button class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">2</button>
                <button class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">3</button>
                <button class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Next</button>
            </div>
        </div>
    </main>

    <!-- Ticket Form Modal -->
    <div id="ticketModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto modal">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-gray-800" id="modalTitle">New Ticket</h3>
                    <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <form id="ticketForm">
                    <input type="hidden" id="ticketId">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                            <input type="text" id="nik" class="w-full form-input rounded-lg border-gray-300" required>
                        </div>
                        <div>
                            <label for="ticket" class="block text-sm font-medium text-gray-700 mb-1">Ticket</label>
                            <input type="text" id="ticket" class="w-full form-input rounded-lg border-gray-300" required>
                        </div>
                        <div>
                            <label for="noInet" class="block text-sm font-medium text-gray-700 mb-1">No INET</label>
                            <input type="text" id="noInet" class="w-full form-input rounded-lg border-gray-300" required>
                        </div>
                        <div>
                            <label for="rfo" class="block text-sm font-medium text-gray-700 mb-1">RFO</label>
                            <select id="rfo" class="w-full form-input rounded-lg border-gray-300" required>
                                <option value="">Select RFO</option>
                                <option value="SAMBUNG">SAMBUНG</option>
                                <option value="CONFUL">CONFUL</option>
                                <option value="GANTI">GANTI</option>
                                <option value="IKR">IKR</option>
                            </select>
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select id="status" class="w-full form-input rounded-lg border-gray-300" required>
                                <option value="PENDING">PENDING</option>
                                <option value="CLOSE">CLOSE</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Photo Capture Section -->
                    <div class="mb-6">
                        <h4 class="text-lg font-medium text-gray-800 mb-3">Selfie Verification</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="photo-container">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Selfie 1</label>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-2 h-40 flex flex-col items-center justify-center relative">
                                    <div id="photoPreview1" class="hidden w-full h-full flex items-center justify-center">
                                        <img id="previewImage1" src="#" alt="Preview of captured selfie image showing work being verified" class="max-h-full max-w-full" />
                                    </div>
                                    <div id="photoPlaceholder1" class="text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <p class="text-xs text-gray-500 mt-2">No image captured</p>
                                    </div>
                                    <input type="hidden" id="photoData1">
                                    <div class="mt-2 flex justify-center space-x-2">
                                        <button type="button" class="camera-btn text-xs px-2 py-1 bg-blue-600 text-white rounded" data-camera="front" data-photo="1" title="Front Camera">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg> Front
                                        </button>
                                        <button type="button" class="camera-btn text-xs px-2 py-1 bg-purple-600 text-white rounded" data-camera="rear" data-photo="1" title="Rear Camera">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg> Rear
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="photo-container">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Selfie 2</label>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-2 h-40 flex flex-col items-center justify-center relative">
                                    <div id="photoPreview2" class="hidden w-full h-full flex items-center justify-center">
                                        <img id="previewImage2" src="#" alt="Preview of captured selfie image showing work being verified" class="max-h-full max-w-full" />
                                    </div>
                                    <div id="photoPlaceholder2" class="text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <p class="text-xs text-gray-500 mt-2">No image captured</p>
                                    </div>
                                    <input type="hidden" id="photoData2">
                                    <div class="mt-2 flex justify-center space-x-2">
                                        <button type="button" class="camera-btn text-xs px-2 py-1 bg-blue-600 text-white rounded" data-camera="front" data-photo="2" title="Front Camera">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg> Front
                                        </button>
                                        <button type="button" class="camera-btn text-xs px-2 py-1 bg-purple-600 text-white rounded" data-camera="rear" data-photo="2" title="Rear Camera">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg> Rear
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="photo-container">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Selfie 3</label>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-2 h-40 flex flex-col items-center justify-center relative">
                                    <div id="photoPreview3" class="hidden w-full h-full flex items-center justify-center">
                                        <img id="previewImage3" src="#" alt="Preview of captured selfie image showing work being verified" class="max-h-full max-w-full" />
                                    </div>
                                    <div id="photoPlaceholder3" class="text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <p class="text-xs text-gray-500 mt-2">No image captured</p>
                                    </div>
                                    <input type="hidden" id="photoData3">
                                    <div class="mt-2 flex justify-center space-x-2">
                                        <button type="button" class="camera-btn text-xs px-2 py-1 bg-blue-600 text-white rounded" data-camera="front" data-photo="3" title="Front Camera">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg> Front
                                        </button>
                                        <button type="button" class="camera-btn text-xs px-2 py-1 bg-purple-600 text-white rounded" data-camera="rear" data-photo="3" title="Rear Camera">
                                            <svg xmlns="www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg> Rear
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="photo-container">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Selfie 4</label>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-2 h-40 flex flex-col items-center justify-center relative">
                                    <div id="photoPreview4" class="hidden w-full h-full flex items-center justify-center">
                                        <img id="previewImage4" src="#" alt="Preview of captured selfie image showing work being verified" class="max-h-full max-w-full" />
                                    </div>
                                    <div id="photoPlaceholder4" class="text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <p class="text-xs text-gray-500 mt-2">No image captured</p>
                                    </div>
                                    <input type="hidden" id="photoData4">
                                    <div class="mt-2 flex justify-center space-x-2">
                                        <button type="button" class="camera-btn text-xs px-2 py-1 bg-blue-600 text-white rounded" data-camera="front" data-photo="4" title="Front Camera">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg> Front
                                        </button>
                                        <button type="button" class="camera-btn text-xs px-2 py-1 bg-purple-600 text-white rounded" data-camera="rear" data-photo="4" title="Rear Camera">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg> Rear
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                        <div class="flex items-center">
                            <input id="confirmationCheck" type="checkbox" class="h-5 w-5 text-blue-600 rounded border-gray-300" required>
                            <label for="confirmationCheck" class="ml-2 text-sm font-medium text-gray-700">I confirm this ticket has been resolved to the customer's satisfaction</label>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <button type="button" id="cancelBtn" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100">Cancel</button>
                        <button type="submit" class="btn-primary text-white px-6 py-3 rounded-lg text-lg font-semibold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Confirm Ticket Resolution
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Camera Modal -->
    <div id="cameraModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md modal">
            <div class="p-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Take Photo</h3>
                    <button id="closeCameraModal" class="text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <div class="relative">
                    <div class="camera-container bg-black rounded-lg overflow-hidden relative">
                        <video id="cameraFeed" autoplay playsinline class="w-full"></video>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="border-2 border-white rounded-full h-48 w-48" style="background: transparent;"></div>
                        </div>
                    </div>
                    
                    <div class="flex justify-center mt-4 space-x-4">
                        <button id="captureBtn" class="bg-white rounded-full h-12 w-12 flex items-center justify-center shadow-lg pulse">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            </svg>
                        </button>
                        <button id="switchCameraBtn" class="bg-gray-200 rounded-full h-12 w-12 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ticket Detail Drawer -->
    <div id="detailDrawer" class="fixed inset-y-0 right-0 w-full max-w-md bg-white shadow-xl z-40 transform translate-x-full transition-transform duration-300 overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-800">Ticket Details</h3>
                <button id="closeDrawer" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="space-y-4">
                <div>
                    <h4 class="font-medium text-gray-700">NIK</h4>
                    <p id="detailNik" class="text-gray-900">-</p>
                </div>
                <div>
                    <h4 class="font-medium text-gray-700">Ticket</h4>
                    <p id="detailTicket" class="text-gray-900">-</p>
                </div>
                <div>
                    <h4 class="font-medium text-gray-700">No INET</h4>
                    <p id="detailNoInet" class="text-gray-900">-</p>
                </div>
                <div>
                    <h4 class="font-medium text-gray-700">RFO</h4>
                    <p id="detailRfo" class="text-gray-900">-</p>
                </div>
                <div>
                    <h4 class="font-medium text-gray-700">Status</h4>
                    <p id="detailStatus" class="inline-block px-2 py-1 rounded-full text-xs font-medium"></p>
                </div>
                
                <div class="pt-4">
                    <h4 class="font-medium text-gray-700 mb-2">Selfie Verification</h4>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="border rounded-lg overflow-hidden">
                            <img id="detailPhoto1" src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/93c90846-d9d0-43d3-9bac-2b104995dbae.png" alt="Placeholder for first selfie verification image showing the technician at work" class="w-full" />
                        </div>
                        <div class="border rounded-lg overflow-hidden">
                            <img id="detailPhoto2" src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/639ddbe3-40e4-4d84-b8df-0ec12f79bf35.png" alt="Placeholder for second selfie verification image showing the completed work" class="w-full" />
                        </div>
                        <div class="border rounded-lg overflow-hidden">
                            <img id="detailPhoto3" src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/58ad8063-54e0-4f64-9cec-9895adbaca46.png" alt="Placeholder for third selfie verification image showing equipment used" class="w-full" />
                        </div>
                        <div class="border rounded-lg overflow-hidden">
                            <img id="detailPhoto4" src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/00f68b6a-40d9-4279-a532-6452869cbeb1.png" alt="Placeholder for fourth selfie verification image showing the location of work" class="w-full" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md modal">
            <div class="p-6">
                <div class="text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-red-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Delete Ticket</h3>
                    <p class="text-gray-600 mb-6">Are you sure you want to delete this ticket? This action cannot be undone.</p>
                    
                    <div class="flex justify-center space-x-4">
                        <button id="cancelDelete" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100">Cancel</button>
                        <button id="confirmDelete" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    // Database connection
    $servername = "localhost";
    $username = "         if (ticketsToDelete) {
                fetch('delete_ticket.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({id: ticketsToDelete})
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting');
                });
            }
        }
            {
                id: 1,
                nik: '1234567890',
                ticket: 'TKT-20230001',
                noInet: 'INET123456',
                rfo: 'SAMBUNG',
                status: 'PENDING',
                photos: [
                    'https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/10a67f73-462b-4c62-9fc1-d018814f6889.png',
                    'https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/c215cdd3-2e60-4ec0-90ea-9b4e82bde4a1.png',
                    'https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/131b5ed3-e889-4a74-b9c8-618eee07ebec.png',
                    'https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/24c2bc8c-06d6-447c-8c0a-4a206e4d166a.png'
                ]
            },
            {
                id: 2,
                nik: '9876543210',
                ticket: 'TKT-20230002',
                noInet: 'INET654321',
                rfo: 'CONFUL',
                status: 'CLOSE',
                photos: [
                    'https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/0fc78baa-8f5e-47bf-9c64-411c60d4566e.png',
                    'https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/a5e21459-b3a7-4925-9981-ead15faca08e.png',
                    'https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/9eb82669-f420-4bd1-9768-d1524e9d8a90.png',
                    'https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/f2e99d25-5723-434f-a41d-b6c74469c7e5.png'
                ]
            }
        ];

        // DOM elements
        const newTicketBtn = document.getElementById('newTicketBtn');
        const ticketModal = document.getElementById('ticketModal');
        const closeModal = document.getElementById('closeModal');
        const ticketForm = document.getElementById('ticketForm');
        const cancelBtn = document.getElementById('cancelBtn');
        const cameraModal = document.getElementById('cameraModal');
        const closeCameraModal = document.getElementById('closeCameraModal');
        const detailDrawer = document.getElementById('detailDrawer');
        const closeDrawer = document.getElementById('closeDrawer');
        const deleteModal = document.getElementById('deleteModal');
        const cancelDelete = document.getElementById('cancelDelete');
        const confirmDelete = document.getElementById('confirmDelete');
        const ticketList = document.getElementById('ticketList');
        const applyFilter = document.getElementById('applyFilter');

        // Camera elements
        const cameraFeed = document.getElementById('cameraFeed');
        const captureBtn = document.getElementById('captureBtn');
        const switchCameraBtn = document.getElementById('switchCameraBtn');

        // Form fields
        const ticketIdField = document.getElementById('ticketId');
        const nikField = document.getElementById('nik');
        const ticketField = document.getElementById('ticket');
        const noInetField = document.getElementById('noInet');
        const rfoField = document.getElementById('rfo');
        const statusField = document.getElementById('status');

        // Camera variables
        let currentStream = null;
        let currentCamera = 'front'; // or 'rear'
        let currentPhoto = 1;
        let ticketsToDelete = null;

        // Initialize the app
        document.addEventListener('DOMContentLoaded', function() {
            // Set default status to CLOSE
            document.getElementById('status').value = 'CLOSE';
            
            // Event listeners for close ticket page
            document.getElementById('newCloseTicketBtn')?.addEventListener('click', openNewTicketModal);
            document.getElementById('confirmationCheck')?.addEventListener('change', function() {
                document.getElementById('cancelBtn').disabled = this.checked;
            });
            closeModal.addEventListener('click', closeTicketModal);
            cancelBtn.addEventListener('click', closeTicketModal);
            
            closeCameraModal.addEventListener('click', closeCameraModalFunc);
            captureBtn.addEventListener('click', capturePhoto);
            switchCameraBtn.addEventListener('click', switchCamera);
            
            closeDrawer.addEventListener('click', closeDetailDrawer);
            
            cancelDelete.addEventListener('click', closeDeleteModal);
            confirmDelete.addEventListener('click', deleteTicket);
            
            applyFilter.addEventListener('click', applyFilters);
            
            // Camera buttons
            document.querySelectorAll('.camera-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    currentPhoto = parseInt(this.getAttribute('data-photo'));
                    currentCamera = this.getAttribute('data-camera');
                    openCameraModal();
                });
            });
            
            // Form submission
            ticketForm.addEventListener('submit', saveTicket);
            
            // Add click handlers for view, edit, delete buttons in ticket list
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('view-btn')) {
                    const ticketId = parseInt(e.target.getAttribute('data-id'));
                    viewTicket(ticketId);
                }
                
                if (e.target.classList.contains('edit-btn')) {
                    const ticketId = parseInt(e.target.getAttribute('data-id'));
                    editTicket(ticketId);
                }
                
                if (e.target.classList.contains('delete-btn')) {
                    const ticketId = parseInt(e.target.getAttribute('data-id'));
                    confirmDeleteTicket(ticketId);
                }
            });
        });

        // Functions
        function renderTicketList(ticketsToRender) {
            ticketList.innerHTML = '';
            
            ticketsToRender.forEach(ticket => {
                const statusClass = ticket.status === 'CLOSE' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800';
                
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50 fade-in';
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">${ticket.nik}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${ticket.ticket}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${ticket.noInet}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${ticket.rfo}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusClass}">${ticket.status}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button class="view-btn text-indigo-600 hover:text-indigo-900 mr-3" data-id="${ticket.id}">View</button>
                        <button class="edit-btn text-green-600 hover:text-green-900 mr-3" data-id="${ticket.id}">Edit</button>
                        <button class="delete-btn text-red-600 hover:text-red-900" data-id="${ticket.id}">Delete</button>
                    </td>
                `;
                
                ticketList.appendChild(row);
            });
        }

        function openNewTicketModal() {
            ticketIdField.value = '';
            ticketForm.reset();
            
            // Reset photo previews
            for (let i = 1; i <= 4; i++) {
                document.getElementById(`photoPreview${i}`).classList.add('hidden');
                document.getElementById(`photoPlaceholder${i}`).classList.remove('hidden');
                document.getElementById(`photoData${i}`).value = '';
            }
            
            document.getElementById('modalTitle').textContent = 'New Ticket';
            ticketModal.classList.remove('hidden');
            document.querySelector('body').classList.add('overflow-hidden');
        }

        function closeTicketModal() {
            ticketModal.classList.add('hidden');
            document.querySelector('body').classList.remove('overflow-hidden');
            
            // Stop camera if it's running
            if (currentStream) {
                currentStream.getTracks().forEach(track => track.stop());
                currentStream = null;
            }
        }

        function openCameraModal() {
            cameraModal.classList.remove('hidden');
            document.querySelector('body').classList.add('overflow-hidden');
            
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                const constraints = {
                    video: {
                        facingMode: currentCamera === 'front' ? 'user' : { exact: 'environment' },
                        width: { ideal: 1280 },
                        height: { ideal: 720 }
                    },
                    audio: false
                };
                
                navigator.mediaDevices.getUserMedia(constraints)
                    .then(stream => {
                        currentStream = stream;
                        cameraFeed.srcObject = stream;
                    })
                    .catch(error => {
                        console.error('Error accessing camera:', error);
                        alert('Could not access the camera. Please make sure you have granted camera permissions.');
                        closeCameraModalFunc();
                    });
            } else {
                alert('Camera access is not supported by your browser.');
                closeCameraModalFunc();
            }
        }

        function closeCameraModalFunc() {
            cameraModal.classList.add('hidden');
            document.querySelector('body').classList.remove('overflow-hidden');
            
            if (currentStream) {
                currentStream.getTracks().forEach(track => track.stop());
                currentStream = null;
            }
        }

        function switchCamera() {
            if (currentStream) {
                currentStream.getTracks().forEach(track => track.stop());
                currentStream = null;
            }
            
            currentCamera = currentCamera === 'front' ? 'rear' : 'front';
            
            const constraints = {
                video: {
                    facingMode: currentCamera === 'front' ? 'user' : { exact: 'environment' },
                    width: { ideal: 1280 },
                    height: { ideal: 720 }
                },
                audio: false
            };
            
            navigator.mediaDevices.getUserMedia(constraints)
                .then(stream => {
                    currentStream = stream;
                    cameraFeed.srcObject = stream;
                })
                .catch(error => {
                    console.error('Error switching camera:', error);
                });
        }

        function capturePhoto() {
            const canvas = document.createElement('canvas');
            canvas.width = cameraFeed.videoWidth;
            canvas.height = cameraFeed.videoHeight;
            const ctx = canvas.getContext('2d');
            
            // Draw a circle in the middle of the canvas
            ctx.beginPath();
            ctx.arc(canvas.width / 2, canvas.height / 2, canvas.width / 2 - 20, 0, Math.PI * 2);
            ctx.closePath();
            ctx.clip();
            
            ctx.drawImage(cameraFeed, 0, 0, canvas.width, canvas.height);
            
            const photoData = canvas.toDataURL('image/jpeg', 0.8);
            
            // Save to the corresponding photo field
            document.getElementById(`photoPreview${currentPhoto}`).classList.remove('hidden');
            document.getElementById(`photoPlaceholder${currentPhoto}`).classList.add('hidden');
            document.getElementById(`previewImage${currentPhoto}`).src = photoData;
            document.getElementById(`photoData${currentPhoto}`).value = photoData;
            
            closeCameraModalFunc();
        }

        function viewTicket(ticketId) {
            const ticket = tickets.find(t => t.id === ticketId);
            
            if (ticket) {
                document.getElementById('detailNik').textContent = ticket.nik;
                document.getElementById('detailTicket').textContent = ticket.ticket;
                document.getElementById('detailNoInet').textContent = ticket.noInet;
                document.getElementById('detailRfo').textContent = ticket.rfo;
                
                const statusElement = document.getElementById('detailStatus');
                statusElement.textContent = ticket.status;
                statusElement.className = 'inline-block px-2 py-1 rounded-full text-xs font-medium ' + 
                    (ticket.status === 'CLOSE' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800');
                
                // Set photos
                for (let i = 0; i < 4; i++) {
                    document.getElementById(`detailPhoto${i+1}`).src = ticket.photos[i] || 'https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/78919d39-cabe-44e2-bf04-606662e258f0.png';
                }
                
                detailDrawer.classList.remove('translate-x-full');
                document.querySelector('body').classList.add('overflow-hidden');
            }
        }

        function closeDetailDrawer() {
            detailDrawer.classList.add('translate-x-full');
            document.querySelector('body').classList.remove('overflow-hidden');
        }

        function editTicket(ticketId) {
            const ticket = tickets.find(t => t.id === ticketId);
            
            if (ticket) {
                ticketIdField.value = ticket.id;
                nikField.value = ticket.nik;
                ticketField.value = ticket.ticket;
                noInetField.value = ticket.noInet;
                rfoField.value = ticket.rfo;
                statusField.value = ticket.status;
                
                // Set photo previews
                for (let i = 0; i < 4; i++) {
                    const previewDiv = document.getElementById(`photoPreview${i+1}`);
                    const placeholderDiv = document.getElementById(`photoPlaceholder${i+1}`);
                    const photoInput = document.getElementById(`photoData${i+1}`);
                    
                    if (ticket.photos[i]) {
                        previewDiv.classList.remove('hidden');
                        placeholderDiv.classList.add('hidden');
                        document.getElementById(`previewImage${i+1}`).src = ticket.photos[i];
                        photoInput.value = ticket.photos[i];
                    } else {
                        previewDiv.classList.add('hidden');
                        placeholderDiv.classList.remove('hidden');
                        photoInput.value = '';
                    }
                }
                
                document.getElementById('modalTitle').textContent = 'Edit Ticket';
                ticketModal.classList.remove('hidden');
                document.querySelector('body').classList.add('overflow-hidden');
            }
        }

        function confirmDeleteTicket(ticketId) {
            ticketsToDelete = ticketId;
            deleteModal.classList.remove('hidden');
            document.querySelector('body').classList.add('overflow-hidden');
        }

        function closeDeleteModal() {
            deleteModal.classList.add('hidden');
            document.querySelector('body').classList.remove('overflow-hidden');
            ticketsToDelete = null;
        }

        function deleteTicket() {
            if (ticketsToDelete) {
                tickets = tickets.filter(t => t.id !== ticketsToDelete);
                renderTicketList(tickets);
                closeDeleteModal();
                
                // Show success message
                alert('Ticket deleted successfully');
            }
        }

        function saveTicket(e) {
            e.preventDefault();
            
            const ticketId = ticketIdField.value ? parseInt(ticketIdField.value) : null;
            const ticketData = {
                nik: nikField.value,
                ticket: ticketField.value,
                noInet: noInetField.value,
                rfo: rfoField.value,
                status: statusField.value,
                photos: []
            };
            
            // Get photo data
            for (let i = 1; i <= 4; i++) {
                const photoData = document.getElementById(`photoData${i}`).value;
                ticketData.photos.push(photoData || 'https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/c00c3a90-40c6-48fc-a6df-fb3091b812c0.png');
            }
            
            if (ticketId) {
                // Update existing ticket
                const index = tickets.findIndex(t => t.id === ticketId);
                if (index !== -1) {
                    ticketData.id = ticketId;
                    tickets[index] = ticketData;
                }
            } else {
                // Add new ticket
                const newId = tickets.length > 0 ? Math.max(...tickets.map(t => t.id)) + 1 : 1;
                ticketData.id = newId;
                tickets.push(ticketData);
            }
            
            renderTicketList(tickets);
            closeTicketModal();
            
            // Show success message
            alert(ticketId ? 'Ticket updated successfully' : 'Ticket created successfully');
        }

        function applyFilters() {
            const statusFilter = document.getElementById('filterStatus').value;
            const nikFilter = document.getElementById('filterNik').value.toLowerCase();
            const ticketFilter = document.getElementById('filterTicket').value.toLowerCase();
            
            let filteredTickets = tickets;
            
            if (statusFilter) {
                filteredTickets = filteredTickets.filter(t => t.status === statusFilter);
            }
            
            if (nikFilter) {
                filteredTickets = filteredTickets.filter(t => t.nik.toLowerCase().includes(nikFilter));
            }
            
            if (ticketFilter) {
                filteredTickets = filteredTickets.filter(t => t.ticket.toLowerCase().includes(ticketFilter));
            }
            
            renderTicketList(filteredTickets);
        }

        // For demo: simulate a database connection
        function connectToDatabase() {
            return {
                query: function(sql, params, callback) {
                    // Simulate database operations
                    setTimeout(() => {
                        if (sql.includes('SELECT')) {
                            callback(null, tickets);
                        } else if (sql.includes('INSERT')) {
                            const newId = tickets.length > 0 ? Math.max(...tickets.map(t => t.id)) + 1 : 1;
                            const newTicket = {
                                id: newId,
                                nik: params[0],
                                ticket: params[1],
                                noInet: params[2],
                                rfo: params[3],
                                status: params[4],
                                photos: params[5]
                            };
                            tickets.push(newTicket);
                            callback(null, { insertId: newId });
                        } else if (sql.includes('UPDATE')) {
                            const index = tickets.findIndex(t => t.id === params[5]);
                            if (index !== -1) {
                                tickets[index] = {
                                    id: params[5],
                                    nik: params[0],
                                    ticket: params[1],
                                    noInet: params[2],
                                    rfo: params[3],
                                    status: params[4],
                                    photos: params[6]
                                };
                            }
                            callback(null, { affectedRows: 1 });
                        } else if (sql.includes('DELETE')) {
                            tickets = tickets.filter(t => t.id !== params[0]);
                            callback(null, { affectedRows: 1 });
                        }
                    }, 100);
                }
            };
        }
    </script>
</body>
</html>
