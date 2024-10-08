<?php

namespace Ok99\PrivateZoneCore\AdminBundle\Block;

use Sonata\BlockBundle\Block\BlockContextInterface;
use Ok99\PrivateZoneCore\PageBundle\Entity\Block;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BaseBlockService;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Translation\TranslatorInterface;

class FormatterBlockService extends \Sonata\FormatterBundle\Block\FormatterBlockService
{
    /**
     * @param string $name
     * @param EngineInterface $templating
     * @param TranslatorInterface $translator
     */
    public function __construct($name, EngineInterface $templating, TranslatorInterface $translator)
    {
        $this->translator = $translator;
        parent::__construct($name, $templating);

    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $content = $blockContext->getBlock()->getSetting('content');

        return $this->renderResponse($blockContext->getTemplate(), array(
            'block'     => $blockContext->getBlock(),
            'settings'  => $blockContext->getSettings(),
            'content'   => $content,
        ), null);
    }

    /**
    * {@inheritdoc}
    */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
        $formMapper->add('translations', 'ok99_privatezone_translations', array(
            'label' => false,
            'locales' => $block->getSite()->getLocales(),
            'fields' => array(
                'enabled' => array(
                    'field_type' => 'checkbox',
                    'required' => false,
                ),
				'settings' => array(
					'field_type' => 'sonata_type_immutable_array',
                    'label' => false,
					'keys' => array(
                        array('content', 'ok99_privatezone_simple_formatter_type', array(
                                'ckeditor_context' => 'formatter',
                            )
                        ),
                    )
                )
            )
        ));
    }

	/**
	 * {@inheritdoc}
	 */
	public function getName()
	{
		return 'Rich Html Text Area';
	}

    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'format'     => 'richhtml',
            'rawContent' => '<b>Insert your custom content here</b>',
            'content'    => '<b>Insert your custom content here</b>',
            'template'   => 'Ok99PrivateZoneAdminBundle:Block:block_formatter.html.twig'
        ));
    }
}
