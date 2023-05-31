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
<html lang="fr">

<head>
    <?php include 'includes/head.inc.php'; ?>

</head>

<body class="m-0 font-sans antialiased font-normal bg-white text-start text-base leading-default text-slate-500">

    <main class="mt-0 transition-all duration-200 ease-soft-in-out">
        <section>
            <div class="relative flex items-center p-0 overflow-hidden bg-center bg-cover min-h-75-screen">
                <div class="container z-10">
                    <div class="flex flex-wrap mt-0 -mx-3">
                        <div class="flex flex-col w-full max-w-full px-3 mx-auto md:flex-0 shrink-0 md:w-6/12 lg:w-5/12 xl:w-4/12">
                            <div class="relative flex flex-col min-w-0 mt-16 break-words bg-transparent border-0 shadow-none rounded-2xl bg-clip-border">
                                <div class="p-6 pb-0 mb-0 bg-transparent border-b-0 rounded-t-2xl">
                                    <h3 class="relative z-10 font-bold text-transparent bg-gradient-to-tl text-2xl from-blue-600 to-cyan-400 bg-clip-text">Bienvenue !</h3>
                                    <p class="mb-0">Veuillez remplir ce formulaire pour vous inscrire</p>
                                </div>
                                <div class="flex-auto p-6">
                                    <form role="form" method="POST" action="/register">
                                        <?php if (isset($_SESSION['error_message'])) : ?>
                                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                                <strong class="font-bold">Erreur !</strong>
                                                <span class="block sm:inline"><?= $_SESSION['error_message']; ?></span>
                                                <?php unset($_SESSION['error_message']); ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (isset($_SESSION['success_message'])) : ?>
                                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                                                <strong class="font-bold">Succès !</strong>
                                                <span class="block sm:inline"><?= $success_message ?></span>
                                                <?php unset($_SESSION['success_message']); ?>
                                            </div>
                                        <?php endif; ?>

                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700" for="name">Nom et prénoms</label>
                                        <div class="mb-4">
                                            <input type="text" name="name" id="name" required class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" placeholder="Nom & Prénoms" aria-label="Email" aria-describedby="email-addon" />
                                        </div>

                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700" for="email">Adresse e-mail</label>
                                        <div class="mb-4">
                                            <input type="email" name="email" id="email" required class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" placeholder="Email" aria-label="Email" aria-describedby="email-addon" />
                                        </div>

                                        <!-- <label class="mb-2 ml-1 font-bold text-xs text-slate-700" for="account_type">Quel type de compte voulez-vous créer ?</label> -->
                                        <input type="hidden" name="account_type" value="fournisseur">
                                        <!-- <div class="relative mb-4">
                                            <select class=" text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:outline-none focus:transition-shadow" id="account_type" name="account_type" required>
                                                <option value="client">Client</option>
                                                <option value="fournisseur">Fournisseur</option>
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path d="M14.95 7.05a1 1 0 0 0-1.41 0L10 10.59l-3.54-3.54a1 1 0 0 0-1.41 1.41l4.24 4.24a1 1 0 0 0 1.41 0l4.24-4.24a1 1 0 0 0 0-1.41z" />
                                                </svg>
                                            </div>
                                        </div> -->

                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700" for="password">Mot de passe</label>
                                        <div class="mb-4">
                                            <input id="password" type="password" placeholder="Mot de passe" name="password" required class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" aria-label="Password" aria-describedby="password-addon" />
                                        </div>

                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700" for="confirm_password">Confirmer le mot de passe</label>
                                        <div class="mb-4">
                                            <input id="confirm_password" type="password" placeholder="Mot de passe" name="confirm_password" required class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" aria-label="Password" aria-describedby="password-addon" />
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="inline-block w-full px-6 py-3 mt-6 mb-0 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-x-25 bg-150 leading-pro text-xs ease-soft-in tracking-tight-soft bg-gradient-to-tl from-blue-600 to-cyan-400 hover:scale-102 hover:shadow-soft-xs active:opacity-85">Sign in</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="p-6 px-1 pt-0 text-center bg-transparent border-t-0 border-t-solid rounded-b-2xl lg:px-2">
                                    <p class="mx-auto mb-6 leading-normal text-sm">
                                        Do you have an account?
                                        <a href="/connexion" class="relative z-10 font-semibold text-transparent bg-gradient-to-tl from-blue-600 to-cyan-400 bg-clip-text">Se connecter</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="w-full max-w-full px-3 lg:flex-0 shrink-0 md:w-6/12">
                            <div class="absolute top-0 hidden w-3/5 h-full -mr-32 overflow-hidden -skew-x-10 -right-40 rounded-bl-xl md:block">
                                <div class="absolute inset-x-0 top-0 z-0 h-full -ml-16 bg-cover skew-x-10" style="background-image: url('../public/img/curved-images/curved6.jpg')"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

</body>
<?php include 'includes/footer.inc.php'; ?>

</html>