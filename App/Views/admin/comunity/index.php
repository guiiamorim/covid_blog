<?php if ($Sessao::retornaMensagem()): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong><?= $Sessao::retornaMensagem() ?></strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<?php elseif ($Sessao::retornaErro()): ?>
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong><?= $Sessao::retornaErro() ?></strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php endif; $Sessao::limpaErro(); $Sessao::limpaMensagem() ?>


<div class="bg-white pb-4 px-4 rounded-sm w-full shadow-sm">
    <div class="flex justify-between w-full pt-6 ">
        <h3 class="ml-3">Gerenciar Comunidades</h3>
    </div>
    <div class="w-full flex justify-end px-2 mt-2">
        <div class="w-full sm:w-64 inline-block relative ">
            <form action="<?= PATH ?>/comunity" method="get">
                <input type="text" name="s"
                       class="leading-snug border border-gray-300 block w-full appearance-none bg-gray-100 text-sm text-gray-600 py-1 px-4 pl-8 rounded-lg"
                       placeholder="Pesquisar"
                       value="<?= $s ?>"/>
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-2 text-gray-300">
                    <svg class="fill-current h-3 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511.999 511.999">
                        <path d="M508.874 478.708L360.142 329.976c28.21-34.827 45.191-79.103 45.191-127.309C405.333 90.917 314.416 0 202.666 0S0 90.917 0 202.667s90.917 202.667 202.667 202.667c48.206 0 92.482-16.982 127.309-45.191l148.732 148.732c4.167 4.165 10.919 4.165 15.086 0l15.081-15.082c4.165-4.166 4.165-10.92-.001-15.085zM202.667 362.667c-88.229 0-160-71.771-160-160s71.771-160 160-160 160 71.771 160 160-71.771 160-160 160z"/>
                    </svg>
                </div>
            </form>
        </div>
    </div>
    <div class="overflow-x-auto mt-6">
        <table class="table-auto border-collapse w-full">
            <thead>
            <tr class="rounded-lg text-sm font-medium text-gray-700 text-left" style="font-size: 0.9674rem">
                <th class="px-4 py-2 bg-gray-200 " style="background-color:#f8f8f8">Nome</th>
                <th class="px-4 py-2 " style="background-color:#f8f8f8">Cidade</th>
                <th class="px-4 py-2 " style="background-color:#f8f8f8">UF</th>
                <th class="px-4 py-2 " style="background-color:#f8f8f8">Ações</th>
            </tr>
            </thead>
            <tbody class="text-sm font-normal text-gray-700">
                <?php if (!empty($comunidades)): ?>
                <?php foreach ($comunidades as $comunidade): ?>
                <tr class="hover:bg-gray-100 border-b border-gray-200 py-10">
                    <td class="px-4 py-4"><?= $comunidade->getNome() ?></td>
                    <td class="px-4 py-4"><?= $comunidade->getCidade()->getNome() ?></td>
                    <td class="px-4 py-4"><?= $comunidade->getCidade()->getUf() ?></td>
                    <td class="px-4 py-4">
                        <div class="inline-flex">
                            <a href="<?= PATH . '/comunity/show/' . $comunidade->getId() ?>" class="bg-gray-500
                            hover:bg-gray-600 text-gray-900 hover:text-gray-900 font-bold py-2 px-4
                            rounded">
                                <i class="fas fa-edit"></i>
                                Editar
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; endif; ?>
            </tbody>
        </table>
        <div class="w-full text-center my-2">
            <span class="text-gray-500">Mostrando <?= $comunidades->getFirstIndex() ?> - <?=
				$comunidades->getLastIndex()
				?> de <?= $comunidades->getNbResults() ?></span>
        </div>
        <div class="w-full inline-flex justify-center">
            <?php $paginationPath = PATH . explode("?", $_SERVER['REQUEST_URI'])[0] . (!empty($s) ? "?s=" . $s : "?")
            ; ?>
            <a href="<?= $paginationPath . "p=" . $comunidades->getFirstPage()
            ?>">
                <div class="h-8 rounded-l text-center bg-gray-100 text-gray-700 border pt-1 px-2">
					< Primeira página
                </div>
            </a>
            <?php
            for ($i = $comunidades->getFirstPage(); $i <= $comunidades->getLastPage(); $i++) {
                $active = "bg-gray-100 hover:bg-gray-300 text-gray-700";
                if ($i == $comunidades->getPage())
                    $active = "bg-blue-500 hover:bg-blue-600 text-white";
                ?>
                <a href="<?= $paginationPath . "p=" . $i ?>">
                    <div class="h-8 w-8 <?= $active ?> text-center border-t border-b pt-1">
                        <?= $i ?>
                    </div>
                </a>
                <?php
            }
            ?>
            <a href="<?= $paginationPath . "p=" . $comunidades->getLastPage()
			?>">
                <div class="h-8 rounded-r text-center bg-gray-100 text-gray-700 border pt-1 px-2">
                    Última página >
                </div>
            </a>
        </div>
    </div>
</div>