<div class="cover" style="background-image: url('<?= PATH ?>/public/img/bg.jpg')"></div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 relative">
            <div class="w-full mx-auto p-3">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-4xl text-center font-semibold text-gray-900 mb-8">Últimas postagens</h1>
                        <div class="row" id="results">

                        </div>

                        <div class="w-full text-center my-2">
                            <span class="text-gray-500">Mostrando <?= $pagination->getFirstIndex() ?> - <?= $pagination->getLastIndex() ?> de <?= $pagination->getNbResults() ?></span>
                        </div>
                        <div class="w-full inline-flex justify-center">
                            <button class="pagination-link" data-page="<?= $pagination->getLastPage() ?>">
                                <div class="h-8 rounded-l text-center bg-gray-100 text-gray-700 border pt-1 px-2">
                                    < Primeira página
                                </div>
                            </button>
							<?php
							for ($i = $pagination->getFirstPage(); $i <= $pagination->getLastPage(); $i++) {
								$active = "bg-gray-100 hover:bg-gray-300 text-gray-700";
								if ($i == $pagination->getPage())
									$active = "bg-blue-500 hover:bg-blue-600 text-white";
								?>
                                <button class="pagination-link" data-page="<?= $i ?>">
                                    <div class="h-8 w-8 <?= $active ?> text-center border-t border-b pt-1">
										<?= $i ?>
                                    </div>
                                </button>
								<?php
							}
							?>
                            <button class="pagination-link" data-page="<?= $pagination->getLastPage() ?>">
                                <div class="h-8 rounded-r text-center bg-gray-100 text-gray-700 border pt-1 px-2">
                                    Última página >
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>