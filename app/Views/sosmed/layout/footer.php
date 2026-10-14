</div> <!-- Close flex flex-1 -->

<!-- Footer -->
<footer class="border-t border-slate-800 bg-slate-950 py-4 text-center text-xs text-slate-400 z-30">
    &copy; <?= date('Y') ?> Live Scoring System - Modul Penginput Performa Sosmed
</footer>

<!-- Script Sidebar Toggle Mobile -->
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }
</script>
</body>

</html>