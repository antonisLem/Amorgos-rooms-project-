document.addEventListener("DOMContentLoaded", function() {
    var images = ["media/panorama1.jpg", "media/panorama2.jpg", "media/panorama3.jpg"]; // List of image filenames
    var currentIndex = 0; // Index of the currently displayed image
    var imageSwap = document.getElementById('imageSwap'); // Get the image element

    // Function to swap images
    function swapImage() {
        currentIndex = (currentIndex + 1) % images.length; // Increment index and wrap around
        imageSwap.style.opacity = 0.8; // Fade out the current image
        setTimeout(function() {
            imageSwap.src = images[currentIndex]; // Set the src attribute of the image
            setTimeout(function() {
                imageSwap.style.opacity = 1; // Fade in the new image
            }, 100); // Delay the fade-in effect to ensure it starts after the new image is loaded
        }, 500); // Delay the image change by 500 milliseconds to match the transition duration
    }
    setInterval(swapImage, 3000); // Call swapImage every 3 seconds (3000 milliseconds)
});