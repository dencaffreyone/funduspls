<?php

namespace App\DependencyInjection\Compiler;

use App\Translation\Manager\TranslationManager;
use App\Translation\Translator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\ServiceLocatorTagPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;


class TranslatorCompilerPass implements CompilerPassInterface
{
    private $translatorServiceId;
    private $readerServiceId;
    private $loaderTag;
    private $debugCommandServiceId;
    private $updateCommandServiceId;

    public function __construct(string $translatorServiceId = 'translator.default', string $readerServiceId = 'translation.reader', string $loaderTag = 'translation.loader', string $debugCommandServiceId = 'console.command.translation_debug', string $updateCommandServiceId = 'console.command.translation_update')
    {
        $this->translatorServiceId = $translatorServiceId;
        $this->readerServiceId = $readerServiceId;
        $this->loaderTag = $loaderTag;
        $this->debugCommandServiceId = $debugCommandServiceId;
        $this->updateCommandServiceId = $updateCommandServiceId;
    }

    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition($this->translatorServiceId)) {
            return;
        }

        $loaders = [];
        $loaderRefs = [];
        foreach ($container->findTaggedServiceIds($this->loaderTag, true) as $id => $attributes) {
            $loaderRefs[$id] = new Reference($id);
            $loaders[$id][] = $attributes[0]['alias'];
            if (isset($attributes[0]['legacy-alias'])) {
                $loaders[$id][] = $attributes[0]['legacy-alias'];
            }
        }

        if ($container->hasDefinition($this->readerServiceId)) {
            $definition = $container->getDefinition($this->readerServiceId);
            foreach ($loaders as $id => $formats) {
                foreach ($formats as $format) {
                    $definition->addMethodCall('addLoader', [$format, $loaderRefs[$id]]);
                }
            }
        }

        $container
            ->findDefinition($this->translatorServiceId)
            ->setClass(Translator::class)
            ->replaceArgument(0, ServiceLocatorTagPass::register($container, $loaderRefs))
            ->replaceArgument(3, $loaders)
            ->addMethodCall("setTranslationManager", [new Reference(TranslationManager::class)])
        ;

        if (!$container->hasParameter('twig.default_path')) {
            return;
        }

        $paths = array_keys($container->getDefinition('twig.template_iterator')->getArgument(2));
        if ($container->hasDefinition($this->debugCommandServiceId)) {
            $definition = $container->getDefinition($this->debugCommandServiceId);
            $definition->replaceArgument(4, $container->getParameter('twig.default_path'));

            if (\count($definition->getArguments()) > 6) {
                $definition->replaceArgument(6, $paths);
            }
        }
        if ($container->hasDefinition($this->updateCommandServiceId)) {
            $definition = $container->getDefinition($this->updateCommandServiceId);
            $definition->replaceArgument(5, $container->getParameter('twig.default_path'));

            if (\count($definition->getArguments()) > 7) {
                $definition->replaceArgument(7, $paths);
            }
        }
    }
}