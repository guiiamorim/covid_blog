<?php

namespace App\Lib;

use App\Models\DAO\BaseDAO;

/**
 *
 */
class Logger {

    const ALTERACAO = 'Alteração';
    const EXCLUSAO  = 'Exclusão';
    const INCLUSAO  = 'Inclusão';

    const EXCEPTIONTABLES = array('token');

    private static $logger;
    private static $table;
    private static $data;
    private static $hasAterations;


    public static function set($DAO, $newValues = null, $table, $id) {

        self::$table = $table;

        $class = explode('\\', get_class($DAO));
        $class = array_pop($class);
        self::$logger = preg_replace('/(?<!\ )[A-Z]/', ' $0', str_replace('DAO', '', $class));

        if (is_numeric($id)) {
            $primaryKey = 'cod'.str_replace('DAO', '', $class);
        } else {
            $primaryKey = trim(explode("=", $id)[0]);
            if (is_numeric(trim(explode("=", $id)[1]))) {
                $id = trim(explode("=", $id)[1]);
            } else {
                $id = $newValues[':'.$primaryKey];
            }
        }

        self::$data                 = array();
        self::$hasAterations        = false;
        self::$data[$primaryKey]    = $id;

        if (!is_null($newValues)) {
            if ($table === 'faturaparcela') {
                $oldValues = $DAO->listarParcela($id);
            } else {
                $oldValues = $DAO->listar($id);
            }

            foreach ($newValues as $key => $value) {
                $key    = str_replace(':', '', $key);
                $method = 'get'.$key;
                if (method_exists($oldValues, $method)) {
                    if ($oldValues->$method() instanceof \DateTime) {
                        $value = new \DateTime($value);
                        if ($oldValues->$method()->format('Y-m-d') !== $value->format('Y-m-d')) {
                            self::$data[$key]['old']    = $oldValues->$method()->format('Y-m-d');
                            self::$data[$key]['new']    = $value->format('Y-m-d');
                            self::$hasAterations        = true;
                        }
                    } elseif ($oldValues->$method() !== $value) {
                        self::$data[$key]['old']    = $oldValues->$method();
                        self::$data[$key]['new']    = $value;
                        self::$hasAterations        = true;
                    }
                }
            }
        }

    }

    public static function writeLog($action) {

        if (($action === self::ALTERACAO and self::$hasAterations or $action !== self::ALTERACAO) and !in_array(self::$table, self::EXCEPTIONTABLES)) {
            try {
                $tipo           = $action . ' de' . self::$logger;
                $texto          = json_encode(self::$data);
                $tabela         = self::$table;
                $codFuncionario = Sessao::retornaLogin()->getCodFuncionario();

                $conexao = Conexao::getConnection();

                $stmt = $conexao->prepare("INSERT INTO usuariolog (codFuncionario, tabela, texto, tipo) VALUES (:codFuncionario, :tabela, :texto, :tipo)");
                $stmt->execute([':codFuncionario' => $codFuncionario, ':tabela' => $tabela, ':texto' => $texto, ':tipo' => $tipo]);
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage(), $e->getCode());
            }

        }

    }






}
