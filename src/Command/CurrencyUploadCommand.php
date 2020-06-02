<?php
/**
 * Комманда загрузки курсов валют
 * php bin/console currency:upload [period in days]
 */

namespace App\Command;

use App\Services\CurrencyService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CurrencyUploadCommand extends Command {

    private const DAILY_URL = 'http://www.cbr.ru/scripts/XML_daily.asp';
    private const DYNAMIC_URL = 'http://www.cbr.ru/scripts/XML_dynamic.asp';


    protected static $defaultName = 'currency:upload';
    private $currencyService = null;

    public function __construct(string $name = null, CurrencyService $currencyService) {
        $this->currencyService = $currencyService;
        parent::__construct($name);
    }

    protected function configure() {
        $this
            ->setDescription('Upload currencies from https://CBR.ru')
            ->addArgument('period', InputArgument::OPTIONAL, 'Period in days (min 30 days, max 120 days)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    : int {
        $io = new SymfonyStyle($input, $output);
        $period = $input->getArgument('period');
        $period = ($period) ?? 30;

        if ((int) $period < 30 || (int) $period > 120) {
            $io->error('Set period in the range from 30 to 120');
            return 0;
        }

        do {
            $agree = $io->ask('Delete all data from DB? [Y/n]');
        } while (null === $agree);

        if ('y' !== mb_strtolower($agree)) {
            $io->warning('Aborted');
            return 0;
        }

        $output->writeln('Deleting...');
        $this->currencyService->deleteAll();
        $dateFrom = new \DateTime('-' . $period . ' days');
        $dateFrom = $dateFrom->format('d/m/Y');
        $dateTo = date('d/m/Y');
        $num = 0;
        try {
            $currencyList = simplexml_load_file(rawurlencode(self::DAILY_URL));
        } catch (\Exception $e) {
            $io->error(sprintf('Upload error: %s', $e->getMessage()));
            return 0;
        }
        $output->writeln(sprintf('Uploading for %d days...', $period));
        foreach ($currencyList->Valute as $currency) {
            $params = [
                'value_id' => (string) $currency->attributes()->{'ID'},
                'name' => (string) $currency->Name,
                'num_code' => (int) $currency->NumCode,
                'char_code' => (string) $currency->CharCode,
            ];
            try {
                $currencyValues = simplexml_load_file(
                    rawurlencode(
                        self::DYNAMIC_URL . '?date_req1=' . $dateFrom . '&date_req2=' . $dateTo . '&VAL_NM_RQ=' . $currency->attributes()->{'ID'}
                    )
                );
            } catch (\Exception $e) {
                $io->error(sprintf('Upload error: %s', $e->getMessage()));
                return 0;
            }

            foreach ($currencyValues as $currencyValue) {
                $params['value'] = (float) str_replace(',', '.', $currencyValue->Value->__toString());
                $params['date'] = new \DateTime((string) $currencyValue->attributes()->{'Date'});
                try {
                    $this->currencyService->new($params);
                } catch (\Exception $e) {
                    $io->error(sprintf('Save error: %s', $e->getMessage()));
                    return 0;
                }
                $num++;
            }
        }


        if ($input->getOption('help')) {
            // ...
        }

        $io->success(sprintf('All currencies are uploaded! %d rows', $num));

        return 0;
    }
}
