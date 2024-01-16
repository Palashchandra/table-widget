<?php
namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class Ol_Table_Elementor extends Widget_Base {

    public function get_name() {
        return 'ol-dynamic-table';
    }

    public function get_title() {
        return esc_html__('Dynamic Table', 'oyolloo-core');
    }

    public function get_icon() {
        return 'eicon-table';
    }

    public function get_categories() {
        return ['oyolloo-core-cat'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            '_section_table_settings',
            [
                'label' => esc_html__('Table Settings', 'oyolloo-core'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'column_heading',
            [
                'label' => esc_html__('Column Heading', 'oyolloo-core'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Column', 'oyolloo-core'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
			'column_desc',
			[
				'label' => esc_html__( 'Description', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Default title', 'textdomain' ),
				'placeholder' => esc_html__( 'Type your title here', 'textdomain' ),
			]
		);

        $repeater->add_control(
            'colspan',
            [
                'label' => esc_html__('Colspan', 'oyolloo-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => 1,
                'min' => 1,
                'max' => 10,
            ]
        );

        $this->add_control(
            'table_columns',
            [
                'label' => esc_html__('Columns', 'oyolloo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'column_heading' => esc_html__('Column 1', 'oyolloo-core'),
                        'colspan' => 1,
                    ],
                    [
                        'column_heading' => esc_html__('Column 2', 'oyolloo-core'),
                        'colspan' => 1,
                    ],
                    [
                        'column_heading' => esc_html__('Column 3', 'oyolloo-core'),
                        'colspan' => 1,
                    ],
                ],
                'title_field' => '{{{ column_heading }}}',
            ]
        );

        $repeater_rows = new Repeater();

        $repeater_rows->add_control(
            'row_data',
            [
                'label' => esc_html__('Row Data', 'oyolloo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'cell_data',
                        'label' => esc_html__('Cell Data', 'oyolloo-core'),
                        'type' => Controls_Manager::WYSIWYG,
                        'default' => esc_html__('Cell Data', 'oyolloo-core'),
                        'label_block' => true,
                    ],
                    [
                        'name' => 'cell_data_icon',
                        'label' => esc_html__( 'Icon', 'textdomain' ),
                        'type' => \Elementor\Controls_Manager::ICONS,
                        'default' => [
                            'value' => 'fas fa-circle',
                            'library' => 'fa-solid',
                        ],
                    ],
                ],
                'default' => [
                    [
                        'cell_data' => esc_html__('Row 1, Cell 1', 'oyolloo-core'),
                    ],
                    [
                        'cell_data' => esc_html__('Row 1, Cell 2', 'oyolloo-core'),
                    ],
                    [
                        'cell_data' => esc_html__('Row 1, Cell 3', 'oyolloo-core'),
                    ],
                ],
                'title_field' => '{{{ cell_data }}}',
            ]
        );

        $this->add_control(
            'table_rows',
            [
                'label' => esc_html__('Rows', 'oyolloo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater_rows->get_controls(),
                'default' => [
                    [
                        'row_data' => [
                            [
                                'cell_data' => esc_html__('Row 1, Cell 1', 'oyolloo-core'),
                            ],
                            [
                                'cell_data' => esc_html__('Row 1, Cell 2', 'oyolloo-core'),
                            ],
                            [
                                'cell_data' => esc_html__('Row 1, Cell 3', 'oyolloo-core'),
                            ],
                        ],
                    ],
                    [
                        'row_data' => [
                            [
                                'cell_data' => esc_html__('Row 1, Cell 1', 'oyolloo-core'),
                            ],
                            [
                                'cell_data' => esc_html__('Row 1, Cell 2', 'oyolloo-core'),
                            ],
                            [
                                'cell_data' => esc_html__('Row 1, Cell 3', 'oyolloo-core'),
                            ],
                        ],
                    ],
                    [
                        'row_data' => [
                            [
                                'cell_data' => esc_html__('Row 1, Cell 1', 'oyolloo-core'),
                            ],
                            [
                                'cell_data' => esc_html__('Row 1, Cell 2', 'oyolloo-core'),
                            ],
                            [
                                'cell_data' => esc_html__('Row 1, Cell 3', 'oyolloo-core'),
                            ],
                        ],
                    ]
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        ?>
        <div class="table_wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <?php foreach ($settings['table_columns'] as $column) : ?>
                            <th colspan="<?php echo $column['colspan']; ?>">
                                <?php if(!empty($column['column_desc'])) : ?>
                                    <span><?php echo $column['column_desc']; ?></span>
                                <?php endif; ?>
                                <?php echo $column['column_heading']; ?>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($settings['table_rows'] as $row) : ?>
                        <tr>
                            <?php foreach ($row['row_data'] as $cell) : ?>
                                <td> 
                                    <?php echo $cell['cell_data']; ?> 
                                    <?php if(!empty($cell['cell_data_icon'])) : ?>
                                        <?php \Elementor\Icons_Manager::render_icon( $cell['cell_data_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register(new Ol_Table_Elementor());
