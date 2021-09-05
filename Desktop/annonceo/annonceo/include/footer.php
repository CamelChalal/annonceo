    </div>

    <!-- Footer -->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Your Website 2020</p>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
        <script type="text/javascript" src="../include/jquery/jquery-ui.js"></script>
        <script type="text/javascript" src="../include/jquery/jquery.ui.autocomplete.js}"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/6ceb07b7b7.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>





        <!-- script disparition des notifications-->
        <script>
            function messageOff() {
                setTimeout(
                    function() {
                        document.querySelector('.disparition').style.display = "none";
                    }, 4000

                );
            }

            messageOff();
        </script>



        <script>
            var loadFile = function(event) {



                var parent = document.getElementById("parent");

                var max = document.getElementById("max");

                let compteur = 0;




                for ($i = 0; $i < event.target.files.length; $i++) {



                    parent.innerHTML += "<div class='col-md-12 text-center picture'><img  src='" + URL.createObjectURL(event.target.files[$i]) + "' style='width:300px'></div>";

                    compteur++;

                }
                if (compteur > 5) {

                    max.setAttribute("disabled", "");
                    message.innerHTML = "<div> 5 photos max </div>";
                }

            }
        </script>




        <!-- <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->


    </footer>
    </body>

    </html>

    <?php

    // la fonction unset permet de supprimer une donnée ou un tableau dans la superglobal $_SESSION
    unset($_SESSION["notification"]);
