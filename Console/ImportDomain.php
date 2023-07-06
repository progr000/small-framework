<?php
namespace Console;

use Core\App;
use Core\ConsoleDriver;
use Core\Exceptions\DbException;
use Core\LogDriver;
use Core\MigrationDriver;
use Exception;
use Models\Examples\mssql\Domain;
use Models\Domain as Receiver;

class ImportDomain extends ConsoleDriver
{
    /** @var string[] */
    protected $available_params = [
        'ImportDomain:wl-domain'      => "\tImport from Domainnamen.domain",
        'ImportDomain:wl-hosting'     => "\tImport from WLAdmin.Rechnungen_Domains",
        'ImportDomain:hs-crm'         => "\tImport from HsCrm.tbl_domains",
        'ImportDomain:truncate'       => "\tTruncate table",
    ];

    /**
     * @return true
     * @throws Exception
     */
    public function init()
    {
        ignore_user_abort(true);
        LogDriver::setVerboseLevel($this->verbose_level);
        LogDriver::setLog(config('logs->ImportDomain.log'));
        return true;
    }

    /**
     * Function for prepare and validate variables and environment
     * before someMethod will be run by starter.
     * @param array $actions
     * @return bool
     */
    public function validate(array $actions)
    {
        //dump($actions);
        return true;
    }

    /**
     * @return void
     * @throws DbException
     */
    protected function wlDomain()
    {
        $limit = 1000;
        $i = 0;
        $total = 0;
        do {
            $domains = Domain::find()
                ->where("domainname NOT LIKE '%[_]'")
                ->orderBy(['id' => "DESC"])
                ->limit($limit)
                ->offset($i*$limit)
                ->get();
            $count = 0;
            if ($domains) {
                $count = count($domains);
                $insert = [];
                foreach ($domains as $domain) {
                    $insert[] = [
                        'domain' => $domain->domainname,
                        'date_reg' => isset($domain->verechnet_bis)
                            ? $domain->verechnet_bis
                            : date('1970-01-01 00:00:00'),
                        'status' => 0,
                    ];
                }
                if (Receiver::insert($insert)) {
                    $total += $count;
                    LogDriver::success("New portion {$count} imported. Total: {$total}", 0);
                } else {
                    LogDriver::error("Fail import new portion {$count}.", 0);
                    dump(Receiver::getErrors());
                    return;
                }
            }
            $i++;
        } while ($count > 0);
    }

    /**
     * @throws DbException
     */
    protected function wlHosting()
    {
        $limit = 1000;
        $i = 0;
        $total = 0;
        do {
            $domains = App::$DbInstances['mssql-wl-hosting']
                ->table('{{Rechnungen_Domains}}')
                ->where("redo_name NOT LIKE '%[_]'")
                ->orderBy(['redo_id' => "DESC"])
                ->limit($limit)
                ->offset($i*$limit)
                ->get();
            $count = 0;
            if ($domains) {
                $count = count($domains);
                $insert = [];
                foreach ($domains as $domain) {
                    $insert[] = [
                        'domain' => $domain->redo_name,
                        'date_reg' => isset($domain->redo_ende)
                            ? $domain->redo_ende
                            : date('1970-01-01 00:00:00'),
                        'status' => 0,
                    ];
                }
                if (Receiver::insert($insert)) {
                    $total += $count;
                    LogDriver::success("New portion {$count} imported. Total: {$total}", 0);
                } else {
                    LogDriver::error("Fail import new portion {$count}.", 0);
                    dump(Receiver::getErrors());
                    return;
                }
            }
            $i++;
        } while ($count > 0);
    }

    /**
     * @throws DbException
     */
    protected function hsCrm()
    {
        $limit = 1000;
        $i = 0;
        $total = 0;
        do {
            $domains = App::$DbInstances['mysql-for-orderdesk']
                ->table('{{domain}}')
                ->alias('t1')
                ->select(['raw' => 'concat(t1.domain, t2.tld) as domain', 't1.registrar_expiredate'])
                ->innerJoin('{{tld}} as t2', 't1.id_tld = t2.id_tld')
                ->where("t1.domain NOT LIKE 'ARCHIV%'")
                ->orderBy(['t1.id_domain' => "DESC"])
                ->limit($limit)
                ->offset($i*$limit)
                ->get();
            $count = 0;
            if ($domains) {
                $count = count($domains);
                $insert = [];
                foreach ($domains as $domain) {
                    $insert[] = [
                        'domain' => $domain->domain,
                        'date_reg' => isset($domain->registrar_expiredate)
                            ? $domain->registrar_expiredate
                            : date('1970-01-01 00:00:00'),
                        'status' => 0,
                    ];
                }
                if (Receiver::insert($insert)) {
                    $total += $count;
                    LogDriver::success("New portion {$count} imported. Total: {$total}", 0);
                } else {
                    LogDriver::error("Fail import new portion {$count}.", 0);
                    dump(Receiver::getErrors());
                    return;
                }
            }
            $i++;
        } while ($count > 0);
    }

    /**
     * @throws DbException
     */
    protected function truncate()
    {
        Receiver::truncate();
    }
}
