<script>
    // Toggle visibility of dropdowns and search bar
    function toggleDropdown(id) {
        const element = document.getElementById(id);
        element.classList.toggle('hidden');
    }

    function toggleSearchBar() {
        const searchBar = document.getElementById('search-bar');
        searchBar.classList.toggle('hidden');
    }

    document.addEventListener('keydown', (event) => {
        const searchBar = document.getElementById('search-bar');
        if (event.key === 'Escape' && !searchBar.classList.contains('hidden')) {
            searchBar.classList.add('hidden');
        }
    });

    // Close all dropdowns except the active one
    document.addEventListener('click', (event) => {
        const dropdowns = ['category-dropdown', 'user-menu'];
        dropdowns.forEach(id => {
            const dropdown = document.getElementById(id);
            const button = document.querySelector(`[onclick*='${id}']`);
            if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Close search bar if clicked outside
        const searchBar = document.getElementById('search-bar');
        const searchButton = document.getElementById('search-button');
        if (!searchBar.contains(event.target) && !searchButton.contains(event.target)) {
            searchBar.classList.add('hidden');
        }
    });
    //
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    }

    function toggleDropdown(id) {
        const element = document.getElementById(id);
        element.classList.toggle('hidden');
    }


    function showLogoutAlert(event) {
        event.preventDefault();
        document.getElementById('logoutModal').classList.remove('hidden');
    }

    function closeLogoutModal() {
        document.getElementById('logoutModal').classList.add('hidden');
    }
</script>
</body>

</html>