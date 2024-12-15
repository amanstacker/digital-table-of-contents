document.addEventListener("DOMContentLoaded", function () {
    const toggleButtons = document.querySelectorAll(".digital-toc .toggle-toc");

    toggleButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const tocList = this.parentElement.parentElement.querySelector('.digital-toc .toc-list');

            if (tocList.classList.contains("hidden")) {
                tocList.classList.remove("hidden");
                this.textContent = "Hide TOC";
            } else {
                tocList.classList.add("hidden");
                this.textContent = "Show TOC";
            }
        });
    });
});
