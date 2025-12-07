document.addEventListener("DOMContentLoaded", () => {
    const blogContent = document.querySelector('.blog-content');
    const readingTimeElement = document.getElementById('reading-time');

    if (blogContent && readingTimeElement) {
        const words = blogContent.innerText.trim().split(/\s+/).length;
        const wordsPerMinute = 200;
        const minutes = Math.ceil(words / wordsPerMinute);
        readingTimeElement.textContent = `${minutes} min read`;
    }

    // Copy Link Function
    function copyBlogLink() {
        navigator.clipboard.writeText(window.location.href);
        alert("Link copied to clipboard!");
    }
    window.copyBlogLink = copyBlogLink;
});
