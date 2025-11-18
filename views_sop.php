<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Standard Operating Procedure - Production</title>
    <style>
        :root {
            --primary-color: #004d99;
            --secondary-color: #007bff;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #17a2b8;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --border-color: #e9ecef;
            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.08);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.12);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.16);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            color: var(--dark-color);
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 0;
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px 32px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(100px, -150px);
        }
        
        .header-left h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 8px 0;
            position: relative;
            z-index: 1;
        }
        
        .header-left p {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.9);
            margin: 0;
            position: relative;
            z-index: 1;
            max-width: 600px;
            line-height: 1.5;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            background-color: var(--success-color);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 12px;
            box-shadow: var(--shadow-sm);
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .header-right {
            display: flex;
            gap: 10px;
            position: relative;
            z-index: 1;
        }
        
        .header-right button {
            background-color: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 10px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .header-right button:hover {
            background-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        
        .header-right .action-button {
            background-color: rgba(255, 255, 255, 0.9);
            color: var(--dark-color);
        }
        
        .header-right .qr-code { background-color: var(--warning-color); color: white; }
        .header-right .download-pdf { background-color: var(--secondary-color); color: white; }
        .header-right .delete { background-color: var(--danger-color); color: white; }
        .info-bar {
            display: flex;
            justify-content: space-between;
            padding: 24px 32px;
            background-color: var(--light-color);
            border-bottom: 1px solid var(--border-color);
        }
        
        .info-item {
            display: flex;
            gap: 40px;
        }
        
        .info-item div {
            display: flex;
            flex-direction: column;
        }
        
        .info-item strong {
            font-size: 13px;
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .info-item span {
            font-size: 16px;
            font-weight: 600;
            color: var(--dark-color);
        }
        
        .content-area {
            padding: 32px;
            min-height: 600px;
        }
        
        .content-area h2 {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 24px;
            position: relative;
            padding-bottom: 12px;
        }
        
        .content-area h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            border-radius: 2px;
        }
        
        .sop-step {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            min-height: 500px;
        }
        
        .visual-area {
            position: relative;
        }
        
        .image-container {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            background-color: var(--light-color);
            aspect-ratio: 4/3;
        }
        
        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }
        
        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(180deg, transparent 0%, rgba(0, 0, 0, 0.4) 100%);
            opacity: 0;
            transition: var(--transition);
        }
        
        .image-container:hover .image-overlay {
            opacity: 1;
        }
        
        .navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            padding: 16px;
            background-color: var(--light-color);
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }
        
        .slide-indicator {
            font-size: 14px;
            font-weight: 600;
            color: var(--dark-color);
            padding: 8px 16px;
            background-color: white;
            border-radius: 20px;
            box-shadow: var(--shadow-sm);
        }
        
        .step-navigation {
            display: flex;
            gap: 8px;
        }
        
        .step-navigation button {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: white;
            border: none;
            color: var(--secondary-color);
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-sm);
        }
        
        .step-navigation button:hover:not(:disabled) {
            background-color: var(--secondary-color);
            color: white;
            transform: scale(1.1);
            box-shadow: var(--shadow-md);
        }
        
        .step-navigation button:disabled {
            color: #adb5bd;
            background-color: var(--light-color);
            cursor: not-allowed;
            transform: scale(1);
        }
        
        .procedure-area {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .step-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 16px;
            padding: 24px;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            border-left: 4px solid var(--secondary-color);
            animation: slideInRight 0.5s ease-out;
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .step-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }
        
        .step-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 16px;
        }
        
        .step-number {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            color: white;
            border-radius: 50%;
            width: 48px;
            height: 48px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 700;
            font-size: 18px;
            flex-shrink: 0;
            box-shadow: var(--shadow-sm);
            position: relative;
        }
        
        .step-number::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            animation: ripple 2s infinite;
        }
        
        @keyframes ripple {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }
        
        .step-content h3 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            color: var(--dark-color);
        }
        
        .step-content p {
            margin: 0;
            line-height: 1.7;
            color: #6c757d;
            font-size: 15px;
            animation: fadeIn 0.8s ease-out;
            transition: opacity 0.3s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        /* Smooth transitions for dynamic content */
        #sopImage, #stepNumber, #stepTitle, #stepDescription {
            transition: opacity 0.3s ease;
        }
        
        /* Hover effects for interactive elements */
        .image-container {
            cursor: pointer;
        }
        
        .step-card {
            cursor: default;
        }
        
        /* Progress dots */
        .progress-dots {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 24px;
        }
        
        .progress-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: var(--border-color);
            transition: var(--transition);
            cursor: pointer;
        }
        
        .progress-dot.active {
            background-color: var(--secondary-color);
            transform: scale(1.5);
        }
        
        .progress-dot:hover {
            background-color: var(--secondary-color);
            opacity: 0.7;
        }
        
        /* Responsive Design */
        @media (max-width: 1024px) {
            .container {
                margin: 20px;
                border-radius: 12px;
            }
            
            .sop-step {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            
            .visual-area {
                order: 1;
            }
            
            .procedure-area {
                order: 2;
            }
        }
        
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 20px;
                padding: 20px;
            }
            
            .header-right {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .info-bar {
                flex-direction: column;
                gap: 20px;
                padding: 20px;
            }
            
            .info-item {
                flex-direction: column;
                gap: 15px;
            }
            
            .content-area {
                padding: 20px;
            }
            
            .step-card {
                padding: 20px;
            }
            
            .step-header {
                gap: 12px;
            }
            
            .step-number {
                width: 40px;
                height: 40px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>

<div class="container">

    <div class="header">
        <div class="header-left">
            <h1>Standard Operating Procedure - Production <span class="status-badge">Active</span></h1>
            <p>Complete production process including setup, execution, quality control, and packaging.</p>
        </div>
        <div class="header-right">
            <button><i class="fas fa-history"></i> History</button>
            <button><i class="fas fa-edit"></i> Edit</button>
            <button class="action-button qr-code"><i class="fas fa-qrcode"></i> QR Code</button>
            <button class="action-button download-pdf"><i class="fas fa-download"></i> Download PDF</button>
            <button class="action-button delete"><i class="fas fa-trash"></i> Delete</button>
            <button><i class="fas fa-thumbtack"></i> PIN</button>
        </div>
    </div>

    <div class="info-bar">
        <div class="info-item">
            <div>
                <strong>Kode SOP</strong>
                <span>SOP-2024-001</span>
            </div>
            <div>
                <strong>Departemen</strong>
                <span>Production</span>
            </div>
        </div>
        <div class="info-item">
            <div>
                <strong>Versi</strong>
                <span>1.0</span>
            </div>
            <div>
                <strong>Last Update</strong>
                <span>11/14/2025</span>
            </div>
        </div>
    </div>

    <div class="content-area">
        <h2>Prosedur & Panduan Visual</h2>

        <div class="sop-step">
            <div class="visual-area">
                <div class="image-container">
                    <img id="sopImage" src="image/1.png" alt="Visualisasi Proses Produksi">
                    <div class="image-overlay"></div>
                </div>
                
                <div class="navigation">
                    <div class="slide-indicator" id="slideIndicator">Slide 1 dari 13</div>
                    <div class="step-navigation">
                        <button id="prevBtn" disabled>&lt;</button> 
                        <button id="nextBtn">&gt;</button> 
                    </div>
                </div>
                
                <div class="progress-dots" id="progressDots">
                    <!-- Progress dots akan di-generate secara dinamis -->
                </div>
            </div>

            <div class="procedure-area">
                <div class="step-card">
                    <div class="step-header">
                        <div class="step-number" id="stepNumber">1</div>
                        <h3 id="stepTitle">Machine Setup</h3>
                        <p id="stepDescription">Prepare production line by checking all equipment connections, verifying power supply, and ensuring all safety guards are in place. Check calibration status of measuring devices.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
<script>
    const sopData = [
        {
            image: 'image/1.png',
            title: 'Machine Setup',
            description: 'Prepare production line by checking all equipment connections, verifying power supply, and ensuring all safety guards are in place. Check calibration status of measuring devices.'
        },
        {
            image: 'image/2.png',
            title: 'Material Loading',
            description: 'Load raw materials into the designated feeders. Ensure correct material type and quantity are used as per production order. Verify material traceability.'
        },
        {
            image: 'image/3.png',
            title: 'Parameter Adjustment',
            description: 'Adjust machine parameters (e.g., temperature, pressure, speed) according to the product specifications. Perform test runs to confirm settings.'
        },
        {
            image: 'image/4.png',
            title: 'First Piece Inspection',
            description: 'Conduct a thorough inspection of the first produced piece to ensure it meets all quality standards and specifications. Document findings and make necessary adjustments.'
        },
        {
            image: 'image/5.png',
            title: 'Production Run',
            description: 'Start the main production run. Monitor machine performance and product quality continuously throughout the process. Address any anomalies promptly.'
        },
        {
            image: 'image/6.png',
            title: 'Quality Control Checks',
            description: 'Perform periodic quality control checks on finished products. This includes dimensional checks, visual inspections, and functional tests. Record all results.'
        },
        {
            image: 'image/7.png',
            title: 'Defect Management',
            description: 'Identify and segregate any defective products. Document the type of defect, root cause, and corrective actions taken. Rework or scrap as per procedure.'
        },
        {
            image: 'image/8.png',
            title: 'Packaging',
            description: 'Package the finished products according to customer requirements and shipping standards. Ensure proper labeling, protective materials, and count accuracy.'
        },
        {
            image: 'image/9.png',
            title: 'Warehouse Transfer',
            description: 'Transfer packaged products to the finished goods warehouse. Update inventory records and ensure proper storage conditions are maintained.'
        },
        {
            image: 'image/10.png',
            title: 'Machine Shutdown',
            description: 'Execute the machine shutdown procedure. Turn off power, relieve pressure, and secure all moving parts. Perform initial cleaning.'
        },
        {
            image: 'image/11.png',
            title: 'Cleaning and Maintenance',
            description: 'Clean the production line thoroughly. Perform routine preventative maintenance checks, lubricate moving parts, and replace worn components if necessary.'
        },
        {
            image: 'image/12.png',
            title: 'Documentation',
            description: 'Complete all production documentation, including shift reports, quality records, and maintenance logs. Ensure all data is accurately recorded and submitted.'
        },
        {
            image: 'image/13.png',
            title: 'Handover',
            description: 'Provide a comprehensive handover to the next shift or department, detailing production status, any issues encountered, and pending tasks.'
        }
    ];

    let currentSlide = 0;
    const totalSlides = sopData.length;

    const sopImage = document.getElementById('sopImage');
    const slideIndicator = document.getElementById('slideIndicator');
    const stepNumber = document.getElementById('stepNumber');
    const stepTitle = document.getElementById('stepTitle');
    const stepDescription = document.getElementById('stepDescription');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const progressDots = document.getElementById('progressDots');

    // Generate progress dots
    function generateProgressDots() {
        progressDots.innerHTML = '';
        for (let i = 0; i < totalSlides; i++) {
            const dot = document.createElement('div');
            dot.className = 'progress-dot';
            if (i === currentSlide) {
                dot.classList.add('active');
            }
            dot.addEventListener('click', () => {
                currentSlide = i;
                updateSlide();
            });
            progressDots.appendChild(dot);
        }
    }

    function updateSlide() {
        const data = sopData[currentSlide];
        
        // Fade out effect
        sopImage.style.opacity = '0';
        stepNumber.style.opacity = '0';
        stepTitle.style.opacity = '0';
        stepDescription.style.opacity = '0';
        
        setTimeout(() => {
            sopImage.src = data.image;
            stepNumber.textContent = currentSlide + 1;
            stepTitle.textContent = data.title;
            stepDescription.textContent = data.description;
            slideIndicator.textContent = `Slide ${currentSlide + 1} dari ${totalSlides}`;
            
            // Fade in effect
            sopImage.style.opacity = '1';
            stepNumber.style.opacity = '1';
            stepTitle.style.opacity = '1';
            stepDescription.style.opacity = '1';
            
            // Update progress dots
            generateProgressDots();
            
            // Disable/enable buttons
            prevBtn.disabled = currentSlide === 0;
            nextBtn.disabled = currentSlide === totalSlides - 1;
        }, 200);
    }

    prevBtn.addEventListener('click', () => {
        if (currentSlide > 0) {
            currentSlide--;
            updateSlide();
        }
    });

    nextBtn.addEventListener('click', () => {
        if (currentSlide < totalSlides - 1) {
            currentSlide++;
            updateSlide();
        }
    });

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft' && !prevBtn.disabled) {
            prevBtn.click();
        } else if (e.key === 'ArrowRight' && !nextBtn.disabled) {
            nextBtn.click();
        }
    });

    // Touch/swipe support for mobile
    let touchStartX = 0;
    let touchEndX = 0;

    sopImage.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    });

    sopImage.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    });

    function handleSwipe() {
        if (touchEndX < touchStartX - 50) {
            // Swipe left - next slide
            if (!nextBtn.disabled) {
                nextBtn.click();
            }
        } else if (touchEndX > touchStartX + 50) {
            // Swipe right - previous slide
            if (!prevBtn.disabled) {
                prevBtn.click();
            }
        }
    }

    // Initial load
    generateProgressDots();
    updateSlide();
</script>
</body>
</html>