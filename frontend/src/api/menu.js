const Menu =  [
  { header: 'Apps' },
  {
    title: 'Principal',
    group: 'apps',
    icon: 'dashboard',
    name: 'Dashboard',
    disabled: true,
    mostra:true,
    rota:"publica",
  },


  {
    title: 'Eventos',
    group: 'widgets',
    component: 'widgets',
    icon: 'edit_calendar',
    rota: "publica",
    disabled: true,
    mostra:false,
    items: [
      { name: 'CadastroEventos', title: 'Cadastro de Evento', component: 'CadastroEventos' },
      { name: 'listEventos', title: 'Lista de Eventos', component: 'listEventos' },
      
    ]
  },
  {
    title: 'Equipamento',
    group: 'widgets',
    component: 'widgets',
    icon: 'handyman',
    rota: "publica",
    disabled: true,
    mostra:false,
    items: [
      { name: 'CadastroEquipamento', title: 'Cadastro de Equipamento', component: 'CadastroEquipamento' },
      { name: 'listEquipamento', title: 'Lista de Equipamento', component: 'listEquipamento' },
      { name: 'EmprestimoEquipamento', title: 'Emprestimo de Equipamento', component: 'EmprestimoEquipamento' },
      { name: 'RelatorioEquipamento', title: 'Relatório dos pedidos de Equipamento', component: 'RelatorioEquipamento' },
    ]
  },
  {
    title: 'Usuário',
    group: 'widgets',
    component: 'widgets',
    icon: 'account_circle',
    rota: "publica",
    disabled: true,
    mostra:false,
    items: [
      { name: 'formCadUsuario', title: 'Cadastro de Usuário', component: 'formCadUsuario'},
      { name: 'listUsuario', title: 'Lista de Usuários', component: 'listUsuario' },
      
    ]
  },
  {
    title: 'Monografia',
    group: 'widgets',
    component: 'widgets',
    icon: 'book',
    rota: "publica",
    disabled: true,
    mostra:false,
    items: [
      { name: 'SolicitMonografia', title: 'Cadastro de Monografia', component: 'SolicitMonografia' },
      { name: 'listMonografia', title: 'Lista de Monografia', component: 'listMonografia' },
      { name: 'RelatorioMonografia', title: 'Relatório dos pedidos de MonografiaS', component: 'RelatorioMonografia' },
      
    ]
  },
  {
    title: 'Professor',
    group: 'widgets',
    component: 'widgets',
    icon: 'school',
    rota: "publica",
    disabled: true,
    mostra:false,
    items: [
      { name: 'CadastroProfessor', title: 'Cadastro de Professor', component: 'CadastroProfessor' },
      { name: 'listProfessor', title: 'Lista de Professores', component: 'listProfessor' },
      
    ]
  },        
  // {
  //   title: 'widgets',
  //   group: 'widgets',
  //   component: 'widgets',
  //   icon: 'widgets',
  //   rota: "publica",
  //   disabled: true,
  //   mostra:false,
  //   items: [
  //     { name: 'social', title: 'Social', component: 'components/social' },
  //     { name: 'statistic', title: 'Statistic', badge: 'new', component: 'components/statistic' },
  //     { name: 'chart', title: 'Chart', component: 'components/chart' },
  //     { name: 'list', title: 'List', component: 'components/widget-list' },
  //   ]
  // },  
  // { header: 'UI Elements' },
  // {
  //   title: 'General',
  //   group: 'components',
  //   component: 'components',
  //   icon: 'tune',
  //   items: [
  //     { name: 'alerts', title: 'Alerts', component: 'components/alerts' },
  //     { name: 'avatars', title: 'Avatars', component: 'components/avatars' },
  //     { name: 'badges', title: 'Badges', component: 'components/badges' },
  //     { name: 'buttons', title: 'Buttons', component: 'components/buttons' },
  //     { name: 'cards', title: 'Cards', component: 'components/cards' },
  //     { name: 'carousels', title: 'Carousels', component: 'components/carousels' },
  //     { name: 'chips', title: 'Chips', component: 'components/chips' },
  //     { name: 'dialogs', title: 'Dialogs', component: 'components/dialogs' },
  //     { name: 'icons', title: 'Icons', component: 'components/icons' },
  //     { name: 'tables', title: 'Data Tables', component: 'components/tables' },
  //     { name: 'parallax', title: 'Parallax  image', component: 'components/parallax' },
  //     { name: 'snackbar', title: 'Snackbar', component: 'components/snackbar' },
  //     { name: 'progress', title: 'Progress', component: 'components/progress' },      
  //     { name: 'slider', title: 'Slider', component: 'components/sliders' },      
  //     { name: 'tooltip', title: 'Tooltip', component: 'components/tooltips' },      
  //     { name: 'pagination', title: 'Pagination', component: 'components/paginations' },      
  //     { name: 'typography', title: 'Typography', component: 'components/typography' },      
  //     { name: 'color', title: 'Color', component: 'components/color' },      

  //   ]
  // },
  // {
  //   title: 'Pickers',
  //   group: 'pickers',
  //   component: 'picker',
  //   icon: 'filter_vintage',
  //   items: [
  //     { name: 'timepicker', title: 'Timepicker', component: 'pickers/timepicker' },     
  //     { name: 'datepicker', title: 'Datepicker', component: 'pickers/datepicker' },      

  //   ]
  // },
  // {
  //   title: 'Layout',
  //   group: 'layout',
  //   component: 'layout',
  //   icon: 'view_compact',
  //   items: [
  //     { name: 'bottom-sheets', title: 'Bottom panels', component: 'components/bottom-sheets' },
  //     { name: 'expansion-panels', title: 'Expansion panels', component: 'components/expansion-panels' },
  //     { name: 'footer', title: 'Footer', component: 'components/footer' },
  //     { name: 'lists', title: 'Lists', component: 'components/lists' },
  //     { name: 'jumbotrons', title: 'Jumbotrons', badge: 'new', component: 'components/jumbotrons' },
  //     { name: 'menus', title: 'Menus', component: 'components/menus' },
  //     { name: 'tabs', title: 'Tabs', component: 'components/tabs' },
  //     { name: 'toolbar', title: 'Toolbars', component: 'components/toolbar' },
  //     { name: 'timeline', title: 'Timeline', component: 'components/timeline' },
  //   ]
  // },  
  // {
  //   title: 'Cadastros',
  //   group: 'forms',
  //   component: 'forms',
  //   icon: 'edit',
  //   items: [
  //     { name: 'cadastro', title: 'Eventos', component: 'components/form-cadastro' },
  //     { name: 'basic', title: 'General', component: 'components/basic-forms' },
  //     { name: 'selects', title: 'Selects', badge: 'new', component: 'components/selects' },
  //     { name: 'selection-controls', title: 'Selection Controls', component: 'components/selection-controls' },
  //     { name: 'text-fields', title: 'Text Fields', component: 'components/text-fields' },
  //     { name: 'steppers', title: 'Steppers', component: 'components/steppers' },
  //     { name: 'editors', title: 'Editors', component: 'components/editors' },
  //   ]
  // },
  // { divider: true },
  // { header: 'Extras' },
  // {
  //   title: 'Pages',
  //   group: 'extra',
  //   icon: 'list',
  //   items: [
  //     { name: 'Login', title: 'Login', component: 'Login' },
  //     { name: '404', title: '404', component: 'NotFound' },
  //     { name: '403', title: '403', component: 'AccessDenied' },
  //     { name: '500', title: '500', component: 'ServerError' },
  //   ]
  // },
];
// reorder menu
Menu.forEach((item) => {
  if (item.items) {
    item.items.sort((x, y) => {
      let textA = x.title.toUpperCase();
      let textB = y.title.toUpperCase();
      return (textA < textB) ? -1 : (textA > textB) ? 1 : 0;
    });
  }
});

export default Menu;
