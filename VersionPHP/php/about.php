<!doctype html>
<html lang="en">

<head>
    <title>About us</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <style>
        body {
            background-color: #f8f9fa;
        }

        main {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <header>
    <?php
    require 'NavbarFilling.php';
    FillNavBar();
    ?>
    </header>
        <main class="container">
            <h2 class="mb-4">About Us</h2>
            <div class="row">
                <div class="col-md-6">
                    <p>
                        We are Samuel Herrera and Samuel James, two passionate
                        programming students. This project was undertaken as
                        part of our studies, where we applied our knowledge to
                        create something unique.
                    </p>
                    <p>
                        Beyond the realm of code, we share a common love for
                        video games, exploring the infinite universes of
                        virtual worlds and discovering new gaming experiences
                        together.
                    </p>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Fun Fact</h5>
                            <p class="card-text">
                                On a lighter note, it's worth mentioning that
                                Samuel James has a peculiar taste for children's
                                movies. He enjoys them thoroughly and never
                                misses an opportunity to tease Samuel Herrera
                                about his more "sophisticated" preferences.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer>
            <!-- place footer here -->
        </footer>
        <!-- Bootstrap JavaScript Libraries -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"></script>
</body>

</html>