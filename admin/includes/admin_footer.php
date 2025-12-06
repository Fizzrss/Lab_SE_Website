<footer>
            <div class="footer clearfix mb-0 text-muted">
                <div class="float-start">
                    <p>2025 &copy; Lab Software Engineering</p>
                </div>
                <div class="float-end">
                    <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span></p>
                </div>
            </div>
        </footer>
        
    </div> 
    <script src="/Lab_SE_Website/admin/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/Lab_SE_Website/admin/assets/compiled/js/app.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <!-- Summernote JS -->
    <?php if (isset($_SESSION['load_summernote']) && $_SESSION['load_summernote']): ?>
    <script src="/Lab_SE_Website/admin/assets/extensions/summernote/summernote-bs5.min.js"></script>
    <?php unset($_SESSION['load_summernote']); ?>
    <?php endif; ?>
</body>
</html>