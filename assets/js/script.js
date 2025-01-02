document.addEventListener("DOMContentLoaded", function () {
    const toggleButtons = document.querySelectorAll(".dtoc-list .toggle-toc");

    toggleButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const tocList = this.parentElement.parentElement.querySelector('.dtoc-list .toc-list');

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
