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

    <!-- page content -->
    <div class="w-full px-6 py-6 mx-auto">
      <!-- table 1 -->

      <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
          <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
              <h6>Mon stock de produits</h6>
              <div x-data="{ open: false }">
                <button x-on:click="open = ! open" data-bs-toggle="modal" data-bs-target="#exampleModal"><small class="text-blue-700"> <i class="fa fa-plus"></i> Ajouter</small></button>
                <div x-show="open" x-transition class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                  <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                  <div class="fixed inset-0 z-10 overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

                      <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <form role="form" method="POST" action="/add_product" enctype="multipart/form-data">

                          <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <!-- Modal content -->
                            <div class="max-w-md mx-auto">
                              <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="image">Image</label>
                                <input name="image" class="text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-blue-300 focus:outline-none focus:transition-shadow" id="image" type="file">
                              </div>
                              <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Nom</label>
                                <input id="name" name="name" type="text" placeholder="Nom du produit" class="text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-blue-300 focus:outline-none focus:transition-shadow">
                              </div>
                              <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Description</label>
                                <textarea id="description" name="description" rows="4" placeholder="Description du produit" class="text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-blue-300 focus:outline-none focus:transition-shadow"></textarea>
                              </div>
                              <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="price">Prix</label>
                                <input id="price" name="price" type="number" step="1" min="1" placeholder="Prix du produit" class="text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-blue-300 focus:outline-none focus:transition-shadow">
                              </div>
                              <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="stock">Nombre en stock</label>
                                <input id="stock" name="quantity" type="number" placeholder="Quantité en stock" class="text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-blue-300 focus:outline-none focus:transition-shadow">
                              </div>
                              <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="category">Catégorie</label>
                                <select id="category" name="category" class="text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-blue-300 focus:outline-none focus:transition-shadow">
                                  <option value="">Sélectionner une catégorie</option>
                                  <?php foreach ($categories as $category) : ?>
                                    <option value="<?= $category->getId() ?>"><?= $category->getName() ?></option>
                                  <?php endforeach; ?>
                                </select>
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

            <?php if (isset($_SESSION['errors_message'])) : ?>
              <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <p class="text-sm text-center">Erreur lors de l'enregistrement</p>
                <?php foreach ($_SESSION['errors_message'] as $field => $error) { ?>
                  <p class="block sm:inline text-xs"><?= $field . ':' . $error . '<br>' ?></p>
                <?php } ?>
              </div>
            <?php endif; ?>

            <div class="flex-auto px-0 pt-0 pb-2">
              <div class="p-0 overflow-x-auto">
                <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                  <thead class="align-bottom">
                    <tr>
                      <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Produit</th>
                      <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Prix</th>
                      <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Statut</th>
                      <th class="px-6 py-3 font-semibold capitalize align-middle bg-transparent border-b border-gray-200 border-solid shadow-none tracking-none whitespace-nowrap text-slate-400 opacity-70"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($products as $product) : ?>
                      <tr>
                        <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                          <div class="flex px-2 py-1">
                            <div>
                              <img src="<?= 'storage/' . $product->getImage() ?>" class="inline-flex items-center justify-center mr-4 text-sm text-white transition-all duration-200 ease-soft-in-out h-9 w-9 rounded-xl" alt="user1" />
                            </div>
                            <div class="flex flex-col justify-center">
                              <h6 class="mb-0 text-sm leading-normal"><?= $product->getName() ?></h6>
                              <p class="mb-0 text-xs leading-tight text-slate-400 w-[200px] truncate"><?= $product->getDescription() ?></p>
                            </div>
                          </div>
                        </td>
                        <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                          <p class="mb-0 text-xs font-semibold leading-tight"><?= $product->getPrice() . " F CFA" ?></p>
                          <p class="mb-0 text-xs leading-tight text-slate-400"><?= $product->getQuantity() . " en stock" ?></p>
                        </td>
                        <td class="p-2 text-sm leading-normal text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                          <span class="bg-gradient-to-tl from-green-600 to-lime-400 px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">
                            <?php $quantity = $product->getQuantity(); ?>

                            <?php if ($quantity == 0) : ?>
                              <span style="color: gray;">Stock épuisé</span>
                            <?php elseif ($quantity <= 5) : ?>
                              <span style="color: red;">Rupture de stock</span>
                            <?php else : ?>
                              <span style="color: green;">En stock</span>
                            <?php endif; ?>
                          </span>
                        </td>
                        <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                          <form x-data="{ open: false }" action="/products/update" method="POST">
                            <input type="hidden" name="product_id" value="<?= $product->getId(); ?>">
                            <a x-on:click="open = ! open" href="javascript:;" class="text-xs font-semibold leading-tight text-slate-400"> Modifier </a>
                            <div x-show="open" x-transition class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                              <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                              <div class="fixed inset-0 z-10 overflow-y-auto">
                                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

                                  <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">

                                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                      <!-- Modal content -->
                                      <div class="max-w-md mx-auto">
                                        <div class="mb-4">
                                          <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Nom</label>
                                          <input id="name" name="name" type="text" value="<?php echo $product->getName(); ?>" placeholder="Nom du produit" class="text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-blue-300 focus:outline-none focus:transition-shadow">
                                        </div>
                                        <div class="mb-4">
                                          <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Description</label>
                                          <textarea id="description" name="description" rows="4" placeholder="Description du produit" class="text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-blue-300 focus:outline-none focus:transition-shadow">
                                            <?php echo $product->getDescription(); ?>
                                        </textarea>
                                        </div>
                                        <div class="mb-4">
                                          <label class="block text-gray-700 text-sm font-bold mb-2" for="price">Prix</label>
                                          <input id="price" name="price" type="number" step="1" min="1" value="<?php echo $product->getPrice(); ?>" placeholder="Prix du produit" class="text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-blue-300 focus:outline-none focus:transition-shadow">
                                        </div>
                                        <div class="mb-4">
                                          <label class="block text-gray-700 text-sm font-bold mb-2" for="stock">Nombre en stock</label>
                                          <input id="stock" name="quantity" type="number" value="<?php echo $product->getQuantity(); ?>" placeholder="Quantité en stock" class="text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-blue-300 focus:outline-none focus:transition-shadow">
                                        </div>
                                        <div class="mb-4">
                                          <label class="block text-gray-700 text-sm font-bold mb-2" for="category">Catégorie</label>
                                          <select id="category" name="category" class="text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-blue-300 focus:outline-none focus:transition-shadow">
                                            <option value="">Sélectionner une catégorie</option>
                                            <?php foreach ($categories as $category) : ?>
                                              <option value="<?= $category->getId() ?>" <?php if ($product->getCategory()->getId() == $category->getId()) echo 'selected'; ?>>
                                                <?php echo  $category->getName(); ?>
                                              </option>
                                            <?php endforeach; ?>
                                          </select>
                                        </div>
                                      </div>

                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                      <!-- Modal footer -->
                                      <button type="submit" class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 sm:ml-3 sm:w-auto">Modifier</button>
                                      <button x-on:click="open = ! open" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancel</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </form>
                          <form action="/products/delete" method="POST">
                            <input type="hidden" name="product_id" value="<?= $product->getId(); ?>">
                            <button type="submit" class="text-xs font-semibold text-red-400 leading-tight "> Supprimer </button>
                          </form>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <!-- page content -->
  </main>

</body>

<?php include 'includes/footer.inc.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>