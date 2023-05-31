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

      <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="p-6 px-4 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
          <h6 class="mb-0">Mes commandes</h6>
        </div>
        <div class="flex-auto p-4 pt-6">
          <?php if (empty($orders)) : ?>
            <div class="p-4 flex justify-center">Aucune commande trouvée.</div>
          <?php else : ?>
            <ul class="flex flex-col pl-0 mb-0 rounded-lg">
              <?php foreach ($orders as $order) : ?>
                <li class="relative flex p-6 mb-2 border-0 rounded-t-inherit rounded-xl bg-gray-50">
                  <div class="flex flex-col">
                    <h6 class="mb-4 leading-normal text-l"><?= $order->getProduct()->getName() ?> </h6>
                    <span class="mb-2 leading-tight text-xs">Quantité: <span class="font-semibold text-slate-700 sm:ml-2"><?= $order->getQuantity() ?></span></span>
                    <span class="mb-2 leading-tight text-xs">Montant Total: <span class="font-semibold text-slate-700 sm:ml-2"><?= $order->getAmount() ?> FCFA</span></span>
                    <span class="mb-2 leading-tight text-xs">Adresse de livraison: <span class="font-semibold text-slate-700 sm:ml-2"><?= $order->getShippingaddress() ?></span></span>
                    <span class="leading-tight text-xs">Statut: <span class="font-semibold text-blue-700 sm:ml-2">
                        <?php if ($order->getStatus() == 'pending') : ?>
                          Pas encore traité
                        <?php elseif ($order->getStatus() == 'processing') : ?>
                          En cours de traitement
                        <?php elseif ($order->getStatus() == 'completed') : ?>
                          Finalisé
                        <?php endif; ?>
                      </span></span>
                  </div>
                  <div class="ml-auto text-right">
                    <a class="text-xs text-red-400 font-bold" href="<?= "/product?q=" . $order->getProduct()->getId() ?>">Voir le produit</a>
                  </div>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div>
      </div>

    </div>

    <!-- page content -->
  </main>

</body>

<?php include 'includes/footer.inc.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>