      document.addEventListener("DOMContentLoaded", function () {

        const sidebar = document.querySelector(".sidebar");

        let startX;

        // Event untuk mendeteksi swipe
        document.addEventListener("touchstart", function (e) {
            startX = e.touches[0].clientX;
        });

        document.addEventListener("touchmove", function (e) {
            let moveX = e.touches[0].clientX;
            let diffX = moveX - startX;

            // Swipe ke kanan untuk membuka sidebar
            if (diffX > 50 && sidebar.classList.contains("closed")) {
                sidebar.classList.remove("closed");
            }
            // Swipe ke kiri untuk menutup sidebar
            else if (diffX < -50 && !sidebar.classList.contains("closed")) {
                sidebar.classList.add("closed");
            }
        });
    });