<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/index.css">
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
                        <?php if (!in_array($_SESSION['role'], ['admin', 'manager', 'staff'])): ?>
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
            
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; 2025 LuxeStay Hotel. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <div id="roomModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" style="display: none;">
        <div class="bg-white rounded-3xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-8">
                <div class="flex justify-between items-start mb-6">
                    <h2 class="text-3xl font-bold playfair" id="modalRoomTitle"></h2>
                    <button onclick="closeRoomModal()" class="text-gray-500 hover:text-gray-700 text-2xl">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div id="modalRoomContent"></div>
            </div>
        </div>
    </div>

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

        async function loadRoomReservations(roomTypeId) {
            try {
                const response = await fetch(`get_room_type_reservations.php?room_type_id=${roomTypeId}`);
                const data = await response.json();
                return data.reservations || [];
            } catch (error) {
                console.error('Error loading reservations:', error);
                return [];
            }
        }

        function openRoomModal(roomType) {
            const modal = document.getElementById('roomModal');
            const modalTitle = document.getElementById('modalRoomTitle');
            const modalContent = document.getElementById('modalRoomContent');
            
            modalTitle.textContent = roomType.type_name;
            
            loadRoomReservations(roomType.room_type_id).then(reservations => {
                let reservationsHTML = '';
                
                if (reservations.length > 0) {
                    reservationsHTML = `
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg mb-6">
                            <h4 class="font-bold text-yellow-800 mb-3 flex items-center">
                                <i class="fas fa-calendar-times mr-2"></i>
                                Occupied Dates
                            </h4>
                            <ul class="space-y-2 max-h-48 overflow-y-auto">
                                ${reservations.map(res => `
                                    <li class="text-sm text-yellow-700 flex items-start">
                                        <i class="fas fa-circle text-xs mt-1 mr-2"></i>
                                        <span>
                                            ${new Date(res.check_in_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })} - 
                                            ${new Date(res.check_out_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}
                                            <span class="ml-2 text-xs bg-yellow-200 px-2 py-1 rounded">${res.status}</span>
                                        </span>
                                    </li>
                                `).join('')}
                            </ul>
                        </div>
                    `;
                } else {
                    reservationsHTML = `
                        <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-lg mb-6">
                            <p class="text-green-700 flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                No upcoming reservations - All dates available!
                            </p>
                        </div>
                    `;
                }
                
                const roomImage = roomType.image_path || defaultRoomImages[roomType.type_name] || defaultRoomImages['Standard'];
                
                let actionButton = '';
                if (['admin', 'manager', 'staff'].includes(userRole)) {
                    actionButton = `
                        <button disabled class="w-full bg-gray-400 text-white py-3 rounded-xl font-semibold cursor-not-allowed">
                            Staff Cannot Book
                        </button>
                    `;
                } else if (isCustomer) {
                    actionButton = `
                        <button onclick="window.location.href='booking.php'" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-3 rounded-xl font-semibold hover:shadow-xl transition shine">
                            <i class="fas fa-calendar-check mr-2"></i>Book Now
                        </button>
                    `;
                } else {
                    actionButton = `
                        <button onclick="window.location.href='login.php'" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-3 rounded-xl font-semibold hover:shadow-xl transition shine">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login to Book
                        </button>
                    `;
                }
                
                modalContent.innerHTML = `
                    <div class="mb-6">
                        <img src="${roomImage}" alt="${roomType.type_name}" class="w-full h-64 object-cover rounded-2xl">
                    </div>
                    
                    <div class="mb-6">
                        <p class="text-gray-600 mb-4">${roomType.description}</p>
                        <div class="flex items-center justify-between bg-gray-50 p-4 rounded-xl">
                            <div class="flex items-center space-x-6">
                                <span class="text-gray-600"><i class="fas fa-user mr-2"></i>${roomType.max_occupancy} Guests</span>
                                <span class="text-gray-600"><i class="fas fa-door-open mr-2"></i>${roomType.count} Rooms</span>
                                <span class="text-green-600 font-semibold"><i class="fas fa-check-circle mr-2"></i>${roomType.availableCount} Available</span>
                            </div>
                            <div class="text-2xl font-bold text-purple-600">₱${parseFloat(roomType.base_price).toFixed(2)}<span class="text-sm text-gray-600">/night</span></div>
                        </div>
                    </div>
                    
                    ${reservationsHTML}
                    
                    ${actionButton}
                `;
                
                modal.style.display = 'flex';
            });
        }

        function closeRoomModal() {
            document.getElementById('roomModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('roomModal');
            if (event.target == modal) {
                closeRoomModal();
            }
        }

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
                                room_type_id: room.room_type_id,
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
                        
                        const roomImage = roomType.image_path || defaultRoomImages[roomType.type_name] || defaultRoomImages['Standard'];
                        
                        const roomCard = `
                            <div class="bg-white rounded-3xl overflow-hidden shadow-xl card-hover cursor-pointer" onclick='openRoomModal(${JSON.stringify(roomType).replace(/'/g, "&#39;")})'>
                                <div class="relative h-64 overflow-hidden">
                                    <img src="${roomImage}" 
                                         alt="${roomType.type_name}" 
                                         class="w-full h-full object-cover transform hover:scale-110 transition duration-500">
                                    <div class="absolute top-4 right-4 bg-white px-4 py-2 rounded-full shadow-lg">
                                        <span class="font-bold text-purple-600">₱${parseFloat(roomType.base_price).toFixed(2)}/night</span>
                                    </div>
                                    <div class="absolute top-4 left-4 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                        ${roomType.availableCount} Available
                                    </div>
                                </div>
                                <div class="p-6">
                                    <h3 class="text-2xl font-bold mb-3 playfair">${roomType.type_name}</h3>
                                    <p class="text-gray-600 mb-4">${roomType.description}</p>
                                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                        <span><i class="fas fa-user mr-2"></i>${roomType.max_occupancy} Guests</span>
                                        <span><i class="fas fa-door-open mr-2"></i>${roomType.count} Rooms</span>
                                    </div>
                                    <button class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-3 rounded-xl font-semibold hover:shadow-xl transition shine">
                                        View Details
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