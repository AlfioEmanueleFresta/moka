
      <hr>

      <footer>
        <p>&copy; [[author]] 2013</p>
      </footer>
    </div>

    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/application.js"></script>
    <?php
    $js_file = "js/pages/{$page}.js";
    if ( is_readable($js_file) ) { ?>
      <script type="text/javascript" src="<?= $js_file; ?>"></script>
    <?php } ?>
  </body>
</html>
