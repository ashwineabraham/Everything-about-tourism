<body topmargin="5" leftmargin="5">

    <table>
        <tr>
            <td><img src="images/button_end_left.gif"><img src="images/search.gif"><img src="images/button_end_right.gif"></td>
        </tr>
        <tr>
            <td>
    
                <form id="searchform" method="post" onsubmit="return false;">
                    <input autocomplete="off" id="searchbox" name="searchq" onkeyup="sendRequest()" type="textbox" size="25">
                    <input type="hidden" name="site" value="<?php echo $_GET["site"]; ?>"></form>

                <div id="show_results"></div>

                <script src="prototype.js" type="text/javascript"></script>

                <script>
                    function sendRequest() {
                        new Ajax.Updater('show_results', 'findresults.php', { method: 'post', parameters: $('searchform').serialize() });
                    }
                </script>

            </td>
        </tr>
        <tr>
            <td><img src="images/calculator.jpg"></td>
        </tr>
    </table>
</body>