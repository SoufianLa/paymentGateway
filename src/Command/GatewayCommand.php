<?php

namespace App\Command;

use App\DTO\TransactionDTO;
use App\Service\Payment\Contract\IPaymentGateway;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:gateway',
    description: 'command line to select specific payment gateway',
)]
class GatewayCommand extends Command
{
    public function __construct(readonly private IPaymentGateway $paymentGateway)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('connectorCode', InputArgument::OPTIONAL, 'connectorCode (shift, aci, sandbox)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $connectorCode = $input->getArgument('connectorCode');

        if ($connectorCode) {
            $io->note(sprintf('You choose payment gateway with connectorCode: %s', $connectorCode));
        }
        try {
            $this->paymentGateway->init($connectorCode);
            $io->info('For testing purposes all card infos, amount, currency are hardcoded');
            $io->horizontalTable(['amount', 'currency', 'cardNumber', 'cardExpMonth', 'cardExpYear', 'cardCvv'],
                [
                    [
                        "10",
                        "EUR",
                        "4200000000000000",
                        "05",
                        "2034",
                        "111",
                    ],
                ]);
            $result = $this->paymentGateway->process(
                new TransactionDTO(
                    "10", "EUR", "4200000000000000",
                    "05", "2034", "111"
                )
            );
            $io->title('Results: ');
            $io->horizontalTable(['transaction ID', 'Date', 'Amount', 'Currency', 'Card bin'],
                [
                    [
                        $result->getTransaction(),
                        $result->getDate(),
                        $result->getAmount(),
                        $result->getCurrency(),
                        $result->getCardBin(),
                    ],
                ]);

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $io->error($e->getMessage());

            return Command::FAILURE;
        }
    }
}
