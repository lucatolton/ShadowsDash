<?php
require("../require/config.php");
session_start();
?>
<!--
=========================================================
* Argon Dashboard - v1.2.0
=========================================================
* Product Page: https://www.creative-tim.com/product/argon-dashboard
* Copyright  Creative Tim (http://www.creative-tim.com)
* Coded by www.creative-tim.com
=========================================================
* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
    <meta name="author" content="Creative Tim">
    <title><?= $_CONFIG["name"] ?> - Pricing selection</title>
    <!-- Favicon -->
    <link rel="icon" href="/assets/img/brand/favicon.png" type="image/png">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="/assets/vendor/nucleo/css/nucleo.css" type="text/css">
    <link rel="stylesheet" href="/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
    <!-- Argon CSS -->
    <link rel="stylesheet" href="/assets/css/argon.css?v=1.2.0" type="text/css">
</head>

<body class="bg-default">
<!-- Navbar -->
<nav id="navbar-main" class="navbar navbar-horizontal navbar-transparent navbar-main navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img src="<?= $_CONFIG["logo_white"] ?>">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse navbar-custom-collapse collapse" id="navbar-collapse">
            <div class="navbar-collapse-header">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="/">
                            <img src="<?= $_CONFIG["logo_white"] ?>">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="<?= $_CONFIG["website"] ?>" class="nav-link">
                        <span class="nav-link-inner--text">Website</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= $_CONFIG["statuspage"] ?>" class="nav-link">
                        <span class="nav-link-inner--text">Status page</span>
                    </a>
                </li>
            </ul>
            <hr class="d-lg-none" />
            <ul class="navbar-nav align-items-lg-center ml-lg-auto">
                <li class="nav-item">
                    <a class="nav-link nav-link-icon" href="<?= $_CONFIG["discordserver"] ?>" target="_blank" data-toggle="tooltip" data-original-title="Like us on Facebook">
                        <i class="fab fa-discord"></i>
                        <span class="nav-link-inner--text d-lg-none">Discord server</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
  <!-- Main content -->
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9">
      <div class="container">
        <div class="header-body text-center mb-7">
          <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 px-5">
              <h1 class="text-white">Select a plan for your account</h1>
            </div>
          </div>
        </div>
      </div>
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>
    <!-- Page content -->
    <div class="container mt--8 pb-5">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="pricing card-group flex-column flex-md-row mb-3">
            <div class="card card-pricing border-0 text-center mb-4">
              <div class="card-header bg-transparent">
                <h4 class="text-uppercase ls-1 text-primary py-3 mb-0">Free plan</h4>
              </div>
              <div class="card-body px-lg-7">
                <div class="display-2">$0</div>
                <span class="text-muted">lifetime</span>
                <ul class="list-unstyled my-4">
                  <li>
                      <div class="d-flex align-items-center">
                          <div>
                              <div class="icon icon-xs icon-shape bg-gradient-primary shadow rounded-circle text-white">
                                  <i class="fas fa-terminal"></i>
                              </div>
                          </div>
                          <div>
                              <span class="pl-2">Game panel will all features</span>
                          </div>
                      </div>
                  </li>
                  <li>
                    <div class="d-flex align-items-center">
                      <div>
                        <div class="icon icon-xs icon-shape bg-gradient-primary shadow rounded-circle text-white">
                          <i class="fas fa-memory"></i>
                        </div>
                      </div>
                      <div>
                        <span class="pl-2">2048MB of RAM</span>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="d-flex align-items-center">
                      <div>
                        <div class="icon icon-xs icon-shape bg-gradient-primary shadow rounded-circle text-white">
                          <i class="fas fa-hdd"></i>
                        </div>
                      </div>
                      <div>
                        <span class="pl-2">10000MB of disk</span>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="d-flex align-items-center">
                      <div>
                          <div class="icon icon-xs icon-shape bg-gradient-primary shadow rounded-circle text-white">
                              <i class="fas fa-microchip"></i>
                          </div>
                      </div>
                      <div>
                        <span class="pl-2">60% of maximum CPU usage</span>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="d-flex align-items-center">
                      <div>
                          <div class="icon icon-xs icon-shape bg-gradient-primary shadow rounded-circle text-white">
                              <i class="fas fa-server"></i>
                          </div>
                      </div>
                      <div>
                          <span class="pl-2">2 servers</span>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="d-flex align-items-center">
                      <div>
                          <div class="icon icon-xs icon-shape bg-gradient-primary shadow rounded-circle text-white">
                              <i class="fas fa-network-wired"></i>
                          </div>
                      </div>
                      <div>
                          <span class="pl-2">0 additional port</span>
                      </div>
                    </div>
                  </li>
                  <li>
                      <div class="d-flex align-items-center">
                          <div>
                              <div class="icon icon-xs icon-shape bg-gradient-primary shadow rounded-circle text-white">
                                  <i class="fas fa-database"></i>
                              </div>
                          </div>
                          <div>
                              <span class="pl-2">0 databases</span>
                          </div>
                      </div>
                  </li>
                </ul>
                <a href="welcome" class="btn btn-primary mb-3">Continue with the free plan</a>
              </div>
            </div>
            <div class="card card-pricing bg-gradient-success zoom-in shadow-lg rounded border-0 text-center mb-4">
              <div class="card-header bg-transparent">
                <h4 class="text-uppercase ls-1 text-white py-3 mb-0">Donator plan</h4>
              </div>
              <div class="card-body px-lg-7">
                <div class="display-1 text-white">$5+</div>
                <span class="text-white">one-time payment</span>
                  <ul class="list-unstyled my-4">
                      <li>
                          <div class="d-flex align-items-center">
                              <div>
                                  <div class="icon icon-xs icon-shape bg-gradient-primary shadow rounded-circle text-white">
                                      <i class="fas fa-terminal"></i>
                                  </div>
                              </div>
                              <div>
                                  <span class="pl-2 text-white">Game panel will all features</span>
                              </div>
                          </div>
                      </li>
                      <li>
                          <div class="d-flex align-items-center">
                              <div>
                                  <div class="icon icon-xs icon-shape bg-gradient-primary shadow rounded-circle text-white">
                                      <i class="fas fa-memory"></i>
                                  </div>
                              </div>
                              <div>
                                  <span class="pl-2 text-white">1024MB of RAM per $1</span>
                              </div>
                          </div>
                      </li>
                      <li>
                          <div class="d-flex align-items-center">
                              <div>
                                  <div class="icon icon-xs icon-shape bg-gradient-primary shadow rounded-circle text-white">
                                      <i class="fas fa-hdd"></i>
                                  </div>
                              </div>
                              <div>
                                  <span class="pl-2 text-white">5000MB of disk per $1</span>
                              </div>
                          </div>
                      </li>
                      <li>
                          <div class="d-flex align-items-center">
                              <div>
                                  <div class="icon icon-xs icon-shape bg-gradient-primary shadow rounded-circle text-white">
                                      <i class="fas fa-microchip"></i>
                                  </div>
                              </div>
                              <div>
                                  <span class="pl-2 text-white">+5% CPU limit per $1</span>
                              </div>
                          </div>
                      </li>
                      <li>
                          <div class="d-flex align-items-center">
                              <div>
                                  <div class="icon icon-xs icon-shape bg-gradient-primary shadow rounded-circle text-white">
                                      <i class="fas fa-server"></i>
                                  </div>
                              </div>
                              <div>
                                  <span class="pl-2 text-white">1 server per $1</span>
                              </div>
                          </div>
                      </li>
                      <li>
                          <div class="d-flex align-items-center">
                              <div>
                                  <div class="icon icon-xs icon-shape bg-gradient-primary shadow rounded-circle text-white">
                                      <i class="fas fa-network-wired"></i>
                                  </div>
                              </div>
                              <div>
                                  <span class="pl-2 text-white">1 port per $1</span>
                              </div>
                          </div>
                      </li>
                      <li>
                          <div class="d-flex align-items-center">
                              <div>
                                  <div class="icon icon-xs icon-shape bg-gradient-primary shadow rounded-circle text-white">
                                      <i class="fas fa-database"></i>
                                  </div>
                              </div>
                              <div>
                                  <span class="pl-2 text-white">1 database per $1</span>
                              </div>
                          </div>
                      </li>
                  </ul>
                <a href="<?= $_CONFIG["discordserver"] ?>" class="btn btn-secondary mb-3">Contact us on Discord</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Footer -->
  <footer class="py-5" id="footer-main">
    <div class="container">
      <div class="row align-items-center justify-content-xl-between">
        <div class="col-xl-6">
          <div class="copyright text-center text-xl-left text-muted">
              &copy; 2021 <a href="https://xshadow.me" class="font-weight-bold ml-1" target="_blank">X_Shadow_#5962</a> - Theme by <a href="https://creativetim.com" target="_blank">Creative Tim</a>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="/assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/vendor/js-cookie/js.cookie.js"></script>
  <script src="/assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
  <script src="/assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
  <!-- Argon JS -->
  <script src="/assets/js/argon.js?v=1.2.0"></script>
  <!-- Demo JS ove this in your project -->
  <script src="/assets/js/demo.min.js"></script>
</body>

</html>