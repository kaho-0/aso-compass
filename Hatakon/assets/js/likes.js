document.addEventListener('DOMContentLoaded', () => {
    const sliderContents = document.querySelector('.slider-contents');
    const scrollSpeed = 1; // Adjust this value to control the scrolling speed

    // Horizontal scroll with the mouse wheel
    document.querySelector('.row').addEventListener('wheel', (e) => {
        e.preventDefault();

        // Determine the amount to scroll based on the wheel delta
        const scrollAmount = e.deltaY * scrollSpeed;

        // Calculate the new scroll position
        const newScrollLeft = sliderContents.scrollLeft + scrollAmount;

        // Set the new scroll position
        sliderContents.scrollLeft = newScrollLeft;
    });
});
