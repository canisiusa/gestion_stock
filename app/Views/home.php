<!--
=========================================================
* Soft UI Dashboard Tailwind - v1.0.5
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard-tailwind
* Copyright 2023 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html>

<head>
  <?php include 'includes/head.inc.php'; ?>
</head>

<body class="m-0 font-sans text-base antialiased font-normal leading-default bg-gray-50 text-slate-500">
  <!-- sidenav  -->
  <?php include 'includes/sidenav.inc.php'; ?>
  <!-- end sidenav -->
  <main class="ease-soft-in-out xl:ml-68.5 relative h-full max-h-screen rounded-xl transition-all duration-200">
    <!-- Navbar -->
    <?php include 'includes/navbar.inc.php'; ?>

    <!-- end Navbar -->

    <!-- cards -->
    <div class="w-full px-6 py-6 mx-auto">
      <div class="flex-none w-full max-w-full px-3 mt-6">
        <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
          <div class="p-4 flex justify-between">
            <div class=" pb-0 mb-0 bg-white rounded-t-2xl">
              <h6 class="mb-1">Liste des produits en stock</h6>
              <p class="leading-normal text-sm">
                <?php if (!empty($_GET['search'])) : ?>
                  Résultats de recherche pour <?php echo $_GET['search']; ?>
                <?php endif; ?>
              </p>
            </div>
            <form method="GET" action="/" class="relative flex flex-wrap items-stretch  transition-all rounded-lg ease-soft">
              <span class="text-sm ease-soft leading-5.6 absolute z-50 -ml-px flex h-full items-center whitespace-nowrap rounded-lg rounded-tr-none rounded-br-none border border-r-0 border-transparent bg-transparent py-2 px-2.5 text-center font-normal text-slate-500 transition-all">
                <i class="fas fa-search"></i>
              </span>
              <input type="search" name="search" class="pl-8.75 text-sm focus:shadow-soft-primary-outline ease-soft w-[300px] leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" placeholder="Rechercher" />
            </form>
          </div>
          <?php if (empty($products)) : ?>
            <div class="p-4 flex justify-center">Aucun produit trouvé.</div>
          <?php else : ?>
            <div class="flex-auto p-4">
              <div class="flex flex-wrap -mx-3">
                <?php foreach ($products as $product) : ?>
                  <div class="w-full max-w-full px-3 mb-6 md:w-6/12 md:flex-none xl:mb-0 xl:w-3/12">
                    <div class="relative flex flex-col min-w-0 break-words bg-transparent border-0 shadow-none rounded-2xl bg-clip-border">
                      <div class="relative">
                        <a class="block shadow-xl rounded-2xl">
                          <img src="<?= 'storage/' . $product->getImage() ?>" alt="img-blur-shadow" class="max-w-full h-[247px] shadow-soft-2xl rounded-2xl" />
                        </a>
                      </div>
                      <div class="flex-auto px-1 pt-6">
                        <p class="relative z-10 mb-2 leading-normal text-transparent bg-gradient-to-tl from-gray-900 to-slate-800 text-sm bg-clip-text"><span class="font-bold"><?= $product->getName() ?></span></p>
                        <h5><?= $product->getPrice() . " fcfa" ?></h5>
                        <p class="mb-2 leading-normal w-full truncate text-sm"><?= $product->getDescription() ?></p>
                        <p class="text-xs text-slate-400 font-bold "> <span class="px-2 py-1 bg-blue-500 text-white rounded-lg"><?= $product->getCategory()->getName() ?></span> </p>
                        <div class="mb-6"></div>
                        <form method="GET" action="<?= "/product" ?>" class="flex items-center justify-between">
                          <input type="hidden" name="q" value="<?=$product->getId()?> ">
                          <button type="submit" class="inline-block px-8 py-2 mb-0 font-bold text-center uppercase align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointer leading-pro ease-soft-in text-xs hover:scale-102 active:shadow-soft-xs tracking-tight-soft border-fuchsia-500 text-fuchsia-500 hover:border-fuchsia-500 hover:bg-transparent hover:text-fuchsia-500 hover:opacity-75 hover:shadow-none active:bg-fuchsia-500 active:text-white active:hover:bg-transparent active:hover:text-fuchsia-500">Voir détails</button>
                        </form>
                      </div>
                    </div>
                  </div>

                <?php endforeach; ?>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <!-- end cards -->
  </main>

</body>

<?php include 'includes/footer.inc.php'; ?>

<!-- plugin for charts  -->
<script src="./assets/js/plugins/chartjs.min.js" async></script>

</html>