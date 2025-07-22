<script>
    document.addEventListener("DOMContentLoaded", function() {
        const items = document.querySelectorAll(".accordion-faq-item");
        items.forEach(item => {
            item.addEventListener("click", () => {
                item.classList.toggle("active");
            });
        });
    });
</script>
