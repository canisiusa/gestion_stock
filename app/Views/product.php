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

    <!-- page content -->
    <div class="w-full px-6 py-6 mx-auto">
      <?php if (isset($_SESSION['errors_message'])) : ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative m-6" role="alert">
          <p class="text-sm text-center">Erreur lors de l'enregistrement</p>
          <?php foreach ($_SESSION['errors_message'] as $field => $error) { ?>
            <p class="block sm:inline text-xs"><?= $field . ':' . $error . '<br>' ?></p>
          <?php } ?>
        </div>
      <?php endif; ?>
      <div class="relative flex flex-col min-w-0 break-words bg-transparent border-0 shadow-none rounded-2xl bg-clip-border">
        <div class="relative flex items-center mb-6">
          <a class="block rounded-2xl">
            <img src="<?= 'storage/' . $product->getImage() ?>" alt="img-blur-shadow" class="max-w-full h-[247px]  rounded-2xl" />
          </a>
          <div class="ml-auto text-right">
            <?php if ($product->getSupplier()->getId() != $_SESSION['user']->getId()) : ?>
              <div class="flex items-center justify-between">
                <div x-data="{ open: false }">
                  <button x-on:click="open = ! open" class="inline-block px-8 py-2 mb-0 font-bold text-center uppercase align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointer leading-pro ease-soft-in text-xs hover:scale-102 active:shadow-soft-xs tracking-tight-soft border-fuchsia-500 text-fuchsia-500 hover:border-fuchsia-500 hover:bg-transparent hover:text-fuchsia-500 hover:opacity-75 hover:shadow-none active:bg-fuchsia-500 active:text-white active:hover:bg-transparent active:hover:text-fuchsia-500">Faire une commande auprès du fournisseur</button>
                  <div x-show="open" x-transition class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                    <div class="fixed inset-0 z-10 overflow-y-auto">
                      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

                        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                          <form role="form" method="POST" action="/order">

                            <input type="hidden" name="product_id" value="<?= $product->getId() ?> ">
                            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                              <!-- Modal content -->
                              <div class="max-w-md mx-auto">

                                <div class="mb-4">
                                  <label class="block text-gray-700 text-sm font-bold mb-2" for="stock">Quantité</label>
                                  <input id="stock" name="quantity" type="number" placeholder="Quantité" class="text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-blue-300 focus:outline-none focus:transition-shadow">
                                </div>
                                <div class="mb-4">
                                  <label class="block text-gray-700 text-sm font-bold mb-2" for="shipping_address">Adresse de livraison</label>
                                  <input id="shipping_address" name="shipping_address" type="text" placeholder="Sasir" class="text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-blue-300 focus:outline-none focus:transition-shadow">
                                </div>

                              </div>

                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                              <!-- Modal footer -->
                              <button type="submit" class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 sm:ml-3 sm:w-auto">Ajouter</button>
                              <button x-on:click="open = ! open" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancel</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php else : ?>
              <p class="w-[350px] text-sm p-6 text-left">Ce produit est le votre. Consultez-en un qui n'est pas le votre pour le commander</p>
            <?php endif; ?>
          </div>
        </div>
        <div class="relative flex p-6 mb-2  border-0 rounded-t-inherit rounded-xl bg-white">
          <div class="flex flex-col">
            <h6 class="mb-4 leading-normal text-xl"><?= $product->getName() ?></h6>
            <span class="mb-2 leading-tight text-xs">Prix: <span class="font-semibold text-slate-700 sm:ml-2"><?= $product->getPrice() . " fcfa" ?></span></span>
            <span class="mb-2 leading-tight text-xs">Quantité en stock: <span class="font-semibold text-slate-700 sm:ml-2"><?= $product->getQuantity() ?></span></span>
            <span class="mb-2 leading-tight text-xs">Catégorie: <span class="font-semibold text-slate-700 sm:ml-2"><?= $product->getCategory()->getName() ?></span></span>
            <span class="leading-tight text-xs">Description: <span class="font-semibold text-slate-700 sm:ml-2"><?= $product->getDescription() ?></span></span>
          </div>
        </div>
        <li class="relative flex p-6 mt-4 mb-2 border-0 rounded-xl bg-white">
          <div class="flex flex-col">
            <h6 class="mb-4 leading-normal text-sm">Fournisseur</h6>
            <span class="mb-2 leading-tight text-xs">Nom et prénoms: <span class="font-semibold text-slate-700 sm:ml-2"><?= $product->getSupplier()->getName() ?></span></span>
            <span class="mb-2 leading-tight text-xs"> Adresse email: <span class="font-semibold text-slate-700 sm:ml-2"><?= $product->getSupplier()->getEmail() ?></span></span>
            <span class="mb-2 leading-tight text-xs">Numéro de telephone: <span class="font-semibold text-slate-700 sm:ml-2"><?= $product->getSupplier()->getPhone() ?></span></span>
            <span class="leading-tight text-xs">Adresse: <span class="font-semibold text-slate-700 sm:ml-2"><?= $product->getSupplier()->getPhone() ?></span></span>
          </div>

        </li>

      </div>

      <!-- page content -->
  </main>

</body>

<?php include 'includes/footer.inc.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>