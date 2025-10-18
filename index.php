<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
    <link rel="stylesheet" href="css/index.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Reservation Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    
    <nav class="fixed w-full z-50 glass shadow-lg">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-hotel text-white text-xl"></i>
                    </div>
                    <span class="text-2xl font-bold playfair text-white">LuxeStay</span>
                </div>
                <div class="flex items-center space-x-6">
                    <a href="#" class="text-white hover:text-purple-300 transition font-medium">Home</a>
                    <a href="#rooms" class="text-white hover:text-purple-300 transition font-medium">Rooms</a>
                    <a href="#features" class="text-white hover:text-purple-300 transition font-medium">Features</a>
                    <a href="#contact" class="text-white hover:text-purple-300 transition font-medium">Contact</a>
                    <?php if (isset($_SESSION['user_id'])): ?>
    <button 
        onclick="window.location.href='<?php 
            echo match ($_SESSION['role']) {
                'admin' => 'admin_dashboard.php',
                'manager' => 'manager_dashboard.php',
                'staff' => 'staff_dashboard.php',
                default => 'dashboard.php'
            }; 
        ?>'" 
        class="bg-white text-purple-600 px-6 py-2 rounded-full font-semibold hover:bg-purple-50 transition shine">
        Dashboard
    </button>
                    <?php if (
                 !in_array($_SESSION['role'], ['admin', 'manager', 'staff'])
                    ): ?>
                     <button 
                    onclick="window.location.href='booking.php'" 
                    class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-6 py-2 rounded-full font-semibold hover:shadow-xl transition shine">
                    Book Now
                    </button>

                    <?php endif; ?>
                        <button onclick="window.location.href='logout.php'" class="bg-red-500 text-white px-6 py-2 rounded-full font-semibold hover:bg-red-600 transition shine">
                            Logout
                        </button>
                    <?php else: ?>
                        <button onclick="window.location.href='login.php'" class="bg-white text-purple-600 px-6 py-2 rounded-full font-semibold hover:bg-purple-50 transition shine">
                            Login
                        </button>
                        <button onclick="window.location.href='register.php'" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-6 py-2 rounded-full font-semibold hover:shadow-xl transition shine">
                            Register
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="hero-slider">
        <div class="hero-slide active" style="background-image: url('https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=1920&q=80')"></div>
        <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1920&q=80')"></div>
        <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=1920&q=80')"></div>
        <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=1920&q=80')"></div>
        
        <div class="absolute inset-0 hero-gradient"></div>
        
        <div class="relative h-full flex items-center justify-center text-center px-6">
            <div class="max-w-4xl float">
                <h1 class="text-7xl font-bold text-white mb-6 playfair leading-tight">
                    Experience Luxury<br/>Beyond Imagination
                </h1>
                <p class="text-xl text-gray-200 mb-12 leading-relaxed">
                    Discover world-class hospitality with breathtaking views, exquisite dining, and unparalleled comfort
                </p>
                <div class="flex justify-center space-x-6">
    <?php if (!isset($_SESSION['role'])): ?>
        <button onclick="window.location.href='login.php'" class="bg-white text-purple-600 px-10 py-4 rounded-full text-lg font-semibold hover:bg-gray-100 transition transform hover:scale-105 shadow-2xl shine">
            <i class="fas fa-calendar-check mr-2"></i>Book Now
        </button>
    <?php elseif (!in_array($_SESSION['role'], ['admin', 'manager', 'staff'])): ?>
        <button onclick="window.location.href='booking.php'" class="bg-white text-purple-600 px-10 py-4 rounded-full text-lg font-semibold hover:bg-gray-100 transition transform hover:scale-105 shadow-2xl shine">
            <i class="fas fa-calendar-check mr-2"></i>Book Now
        </button>
        <button onclick="window.location.href='dashboard.php'" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-10 py-4 rounded-full text-lg font-semibold hover:shadow-2xl transition transform hover:scale-105 shine">
            <i class="fas fa-tachometer-alt mr-2"></i>Go to Dashboard
        </button>
    <?php endif; ?>
</div>

            </div>
        </div>
        
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2">
            <i class="fas fa-chevron-down text-white text-3xl animate-bounce"></i>
        </div>
    </div>

    <div class="relative -mt-20 z-10 max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-3xl mx-auto">
            <div class="bg-white rounded-2xl p-8 shadow-2xl card-hover">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-xl flex items-center justify-center mb-6">
                    <i class="fas fa-bed text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold mb-3 playfair" id="total-rooms">0</h3>
                <p class="text-gray-600 font-medium">Total Rooms</p>
            </div>
            
            <div class="bg-white rounded-2xl p-8 shadow-2xl card-hover">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center mb-6">
                    <i class="fas fa-check-circle text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold mb-3 playfair" id="available-rooms">0</h3>
                <p class="text-gray-600 font-medium">Available Rooms</p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-24" id="rooms">
        <div class="text-center mb-16">
            <span class="text-purple-600 font-semibold text-lg tracking-wide uppercase">Our Rooms</span>
            <h2 class="text-5xl font-bold mt-4 mb-6 playfair">Discover Your Perfect Stay</h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">Each room is uniquely designed to provide you with the ultimate comfort and luxury experience</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8" id="rooms-container">
        </div>
    </div>

    <div class="bg-gradient-to-br from-purple-600 via-indigo-600 to-purple-800 py-24" id="features">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="text-purple-200 font-semibold text-lg tracking-wide uppercase">Why Choose Us</span>
                <h2 class="text-5xl font-bold mt-4 mb-6 text-white playfair">Your Perfect Stay Experience</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-3xl p-8 card-hover border border-white border-opacity-20">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-calendar-check text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4 playfair">Easy Online Booking</h3>
                    <p class="text-purple-100">Book your perfect room in just a few clicks with real-time availability and instant confirmation</p>
                </div>
                
                <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-3xl p-8 card-hover border border-white border-opacity-20">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-history text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4 playfair">Booking History</h3>
                    <p class="text-purple-100">Access your complete reservation history and easily rebook your favorite rooms</p>
                </div>
                
                <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-3xl p-8 card-hover border border-white border-opacity-20">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-credit-card text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4 playfair">Secure Payments</h3>
                    <p class="text-purple-100">Safe and convenient payment processing with multiple payment options available</p>
                </div>
                
                <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-3xl p-8 card-hover border border-white border-opacity-20">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-bed text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4 playfair">Wide Room Selection</h3>
                    <p class="text-purple-100">Choose from various room types designed to meet every need and budget preference</p>
                </div>
                
                <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-3xl p-8 card-hover border border-white border-opacity-20">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-user-circle text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4 playfair">Personal Account</h3>
                    <p class="text-purple-100">Manage your profile, preferences, and bookings all in one convenient dashboard</p>
                </div>
                
                <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-3xl p-8 card-hover border border-white border-opacity-20">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-comments text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4 playfair">Special Requests</h3>
                    <p class="text-purple-100">Customize your stay with special requests and preferences for a personalized experience</p>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-gray-900 text-white py-16" id="contact">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div>
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-hotel text-white text-xl"></i>
                        </div>
                        <span class="text-2xl font-bold playfair">LuxeStay</span>
                    </div>
                    <p class="text-gray-400 leading-relaxed">Experience luxury and comfort like never before. Your perfect stay awaits.</p>
                </div>
                
                <div>
                    <h3 class="text-lg font-bold mb-4">Quick Links</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">About Us</a></li>
                        <li><a href="#rooms" class="text-gray-400 hover:text-white transition">Our Rooms</a></li>
                        <li><a href="#features" class="text-gray-400 hover:text-white transition">Features</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-bold mb-4">Contact Info</h3>
                    <ul class="space-y-3 text-gray-400">
                        <li><i class="fas fa-map-marker-alt mr-3"></i>Q23J+R9M, Congressional Rd Ext, Barangay 171, Caloocan. </li>
                    </ul>
                </div>
                
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; 2025 LuxeStay Hotel. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
    const heroSlides = document.querySelectorAll('.hero-slide');
    let currentSlide = 0;

    function nextSlide() {
        heroSlides[currentSlide].classList.remove('active');
        currentSlide = (currentSlide + 1) % heroSlides.length;
        heroSlides[currentSlide].classList.add('active');
    }

    setInterval(nextSlide, 5000);

    const defaultRoomImages = {
        'Standard': 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=800&q=80',
        'Deluxe': 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=800&q=80',
        'Suite': 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800&q=80',
        'Family Room': 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?w=800&q=80'
    };

    const isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
    const userRole = '<?php echo $_SESSION['role'] ?? ''; ?>';
    const isCustomer = isLoggedIn && !['admin', 'manager', 'staff'].includes(userRole);

    async function loadRooms() {
        try {
            const response = await fetch('get_rooms.php');
            
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            
            const data = await response.json();
            
            if (data.success && data.rooms && data.rooms.length > 0) {
                const roomsContainer = document.getElementById('rooms-container');
                const roomTypes = {};
                
                data.rooms.forEach(room => {
                    const typeName = room.type_name || 'Standard';
                    
                    if (!roomTypes[typeName]) {
                        roomTypes[typeName] = {
                            type_name: typeName,
                            base_price: room.base_price || 0,
                            description: room.description || 'Comfortable room with modern amenities',
                            max_occupancy: room.max_occupancy || 2,
                            image_path: room.image_path || null,
                            count: 0,
                            availableCount: 0
                        };
                    }
                    
                    roomTypes[typeName].count++;
                    
                    if (room.status === 'available') {
                        roomTypes[typeName].availableCount++;
                    }
                });
                
                roomsContainer.innerHTML = '';
                
                let totalRooms = 0;
                let totalAvailable = 0;
                
                Object.values(roomTypes).forEach(roomType => {
                    totalRooms += roomType.count;
                    totalAvailable += roomType.availableCount;
                    
                    const isFullyBooked = roomType.availableCount === 0;
                    
                    let bookNowAction = '';
                    let buttonDisabled = false;
                    let buttonText = 'Book Now';
                    let buttonClass = 'w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-3 rounded-xl font-semibold hover:shadow-xl transition shine';
                    
                    if (isFullyBooked) {
                        buttonDisabled = true;
                        buttonText = 'Fully Booked';
                        buttonClass += ' opacity-50 cursor-not-allowed';
                    } else if (['admin', 'manager', 'staff'].includes(userRole)) {
                        buttonDisabled = true;
                        buttonText = 'Book Now';
                        buttonClass += ' opacity-50 cursor-not-allowed';
                    } else if (isCustomer) {
                        bookNowAction = 'window.location.href=\'booking.php\'';
                    } else if (!isLoggedIn) {
                        bookNowAction = 'window.location.href=\'login.php\'';
                    }
                    
                    const roomImage = roomType.image_path ? roomType.image_path : (defaultRoomImages[roomType.type_name] || defaultRoomImages['Standard']);
                    
                    const roomCard = `
                        <div class="bg-white rounded-3xl overflow-hidden shadow-xl card-hover">
                            <div class="relative h-64 overflow-hidden">
                                <img src="${roomImage}" 
                                     alt="${roomType.type_name}" 
                                     class="w-full h-full object-cover transform hover:scale-110 transition duration-500">
                                ${!isFullyBooked ? 
                                    `<div class="absolute top-4 right-4 bg-white px-4 py-2 rounded-full shadow-lg">
                                        <span class="font-bold text-purple-600">₱${parseFloat(roomType.base_price).toFixed(2)}/night</span>
                                    </div>
                                    <div class="absolute top-4 left-4 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                        ${roomType.availableCount} Available
                                    </div>` : 
                                    `<div class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                        Fully Booked
                                    </div>`
                                }
                            </div>
                            <div class="p-6">
                                <h3 class="text-2xl font-bold mb-3 playfair">${roomType.type_name}</h3>
                                <p class="text-gray-600 mb-4">${roomType.description}</p>
                                <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                    <span><i class="fas fa-user mr-2"></i>${roomType.max_occupancy} Guests</span>
                                    <span><i class="fas fa-door-open mr-2"></i>${roomType.count} Rooms</span>
                                </div>
                                <button onclick="${bookNowAction}" class="${buttonClass}" ${buttonDisabled ? 'disabled' : ''}>
                                    ${buttonText}
                                </button>
                            </div>
                        </div>
                    `;
                    roomsContainer.innerHTML += roomCard;
                });
                
                document.getElementById('total-rooms').textContent = totalRooms;
                document.getElementById('available-rooms').textContent = totalAvailable;
            } else {
                showNoRoomsMessage();
            }
        } catch (error) {
            console.error('Error loading rooms:', error);
            showNoRoomsMessage();
        }
    }

    function showNoRoomsMessage() {
        const roomsContainer = document.getElementById('rooms-container');
        roomsContainer.innerHTML = '<div class="col-span-full text-center py-12"><p class="text-gray-600 text-lg">No rooms available at the moment. Please check back later.</p></div>';
        document.getElementById('total-rooms').textContent = '0';
        document.getElementById('available-rooms').textContent = '0';
    }

    loadRooms();
    </script>
</body>
</html>