<?php

namespace spec\Jjanvier\Bundle\CrowdinBundle\Command\Api;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Crowdin\Api\DeleteDirectory;
use Crowdin\Client as CrowdinClient;

class DirectoryDeleteCommandSpec extends ObjectBehavior
{
    function let(InputInterface $input)
    {
        $input->bind(Argument::cetera())->willReturn();
        $input->isInteractive()->willReturn(false);
        $input->validate()->willReturn();
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Jjanvier\Bundle\CrowdinBundle\Command\Api\DirectoryDeleteCommand');
    }

    function it_is_an_abstract_command()
    {
        $this->shouldHaveType('Jjanvier\Bundle\CrowdinBundle\Command\Api\AbstractApiCommand');
    }

    function it_is_a_container_aware_command()
    {
        $this->shouldHaveType('Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand');
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('crowdin:api:delete-directory');
    }

    function it_deletes_a_directory(InputInterface $input, OutputInterface $output, DeleteDirectory $api, CrowdinClient $client)
    {
        $input->getArgument('directory')->willReturn('directory/to/delete');

        $client->api('delete-directory')->shouldBeCalled();
        $client->api('delete-directory')->willReturn($api);
        $this->setClient($client);

        $api->setDirectory('directory/to/delete')->shouldBeCalled();
        $api->execute()->shouldBeCalled();

        $this->run($input, $output);
    }
}
