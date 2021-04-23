<?php
// GLOBAL VARIABLES
$TRK_CURR = '';

// LANDING STRINGS
const
    MENU_REGISTER = 'Cadastrar',
    MENU_LOGIN = 'Entrar',
    LANDING_SITE_DESC = 'Currículos dinâmicos para profissionais de T.I.',
    LANDING_FIRST_TITLE = 'Sem abobrinha',
    LANDING_FIRST_MESSAGE = 'Para criar sua conta, precisamos apenas de um email válido, nome e telefone ;)',
    LANDING_SECOND_TITLE = 'É mais fácil do que parece',
    LANDING_SECOND_MESSAGE = 'Informe apenas aquilo que é necessário, sem dificuldades. Nós iremos te guiar em todos os passos.',
    LANDING_THIRD_TITLE = 'O controle é todo seu',
    LANDING_THIRD_MESSAGE = 'Você só vai mostrar o que você quiser, como quiser. Envie o link da sua página para todo mundo, ou baixe seu currículo em PDF e compartilhe.';

// USER STRINGS
const
    USER_MENU_ABOUT = 'Quem sou eu',
    USER_MENU_EXPERIENCE = 'Experiência',
    USER_MENU_PROJECTS = 'Portfolio',
    USER_MENU_EDUCATION = 'Formação',
    USER_MENU_SKILLS = 'Habilidades',
    USER_MENU_INTERESTS = 'Mais informações',
    USER_FILTER = 'Localizar currículo',
    USER_FILTER_TITLE_FIRST = 'Encontre quem você',
    USER_FILTER_TITLE_LAST = 'procura',
    USER_FILTER_MESSAGE = 'Informe o nome do usuário e tentaremos localizar o currículo correspondente.',
    USER_FILTER_ERROR_TITLE_FIRST = 'Não encontramos quem você',
    USER_FILTER_ERROR_TITLE_LAST = 'procura',
    USER_FILTER_ERROR_MESSAGE = 'Verifique se o nome de usuário que você buscou está correto e tente novamente.',
    USER_CURRENT = 'Atualmente';

// GENERAL STRINGS
const
    INT_TITLE = 'Dashboard',
    EXT_TITLE = 'T.Indica',
    BASE_ADMIN_URL = '/rafael-site/admin/',
    BASE_USER_URL = '/rafael-site/user/',
    BASE_COMMON_URL = '/rafael-site/common/',
    BASE_VENDOR_URL = '/rafael-site/common/vendor/',
    BASE_LANDING_URL = '/rafael-site/landing/',
    BASE_API_URL = '/rafael-site/api/',
    BASE_PDF_URL = '/rafael-site/data/pdf/',
    VISIBLE = 'Visível só para mim',
    TITLE_404 = 'Oh no!';
    $FOOTER_VALUE = EXT_TITLE.', '.date('Y');

// MAIL STRINGD
const
    CONFIRMATION_EMAIL_SUBJECT = 'Bem-vindo à T.Indica 🤩',
    CONFIRMATION_EMAIL_TITLE = 'É  muito bom ter você por aqui.',
    CONFIRMATION_EMAIL_BODY_FIRST = 'Se você recebeu esse e-mail, quer dizer que acabou de fazer seu cadastro na nossa plataforma. Mas antes de qualquer coisa, precisamos confirmar que essa solicitação realmente veio de você.',
    CONFIRMATION_EMAIL_BODY_SECOND = 'Se você criou uma conta na T.Indica, clique aqui. Após a confirmação, seu acesso vai ser liberado, e você vai poder conhecer todas as facilidades que a T.Indica oferece pra você.',
    CONFIRMATION_EMAIL_BODY_BYE = 'Até mais!',
    PASSWORD_RESET_EMAIL_SUBJECT = 'Seu link para redefinir senha está aqui 😉',
    PASSWORD_RESET_EMAIL_TITLE = 'Parece que alguém esqueceu a senha...',
    PASSWORD_RESET_EMAIL_BODY_FIRST = '...mas não se preocupe. O processo para recuperar sua senha é super simples. Basta acessar esse link, seguir os passos e, finalmente, realizar seu novo acesso.',
    PASSWORD_RESET_EMAIL_BODY_BYE = 'Estamos à disposição!',
    EMAIL_BODY_SENDER = '- starboy',
    SMTP_HOST = 'email-ssl.com.br',
    EMAIL_SENDER = 'tindica@rafaelcouto.eti.br',
    EMAIL_SENDER_NAME = 'T.Indica',
    EMAIL_PASSWORD = '';

// SUCCESS MESSAGES
const
    SUC_FORGOT_LINK_SENT = 'Dá uma olhadinha no seu e-mail. Em breve deve chegar por lá um link para atualizar a senha ;)',
    SUC_RESEND_EMAIL = 'Reenviamos o e-mail. Em breve deve chegar na sua caixa de entrada ou spam ;)',
    SUC_REGISTRATION = 'Dá uma olhadinha no seu e-mail. Em breve deve chegar por lá um link de confirmaçao ;)',
    SUC_CONFIRMATION = 'Prontinho! Já pode fazer login com sua conta.',
    SUC_ACCOUNT_EXISTS = 'Encontramos uma conta com esse e-mail. Faça login ;)',
    SUC_GRAD_SAVE = 'Item salvo em sua formação acadêmica! Uhuul!',
    SUC_GRAD_UPDATE = 'A graduação foi atualizada ;)',
    SUC_GRAD_DEL = 'Prontinho! Formação removida :)',
    SUC_WORK_SAVE = 'Item salvo em sua experiência profissional! Uhuul!',
    SUC_WORK_UPDATE = 'A experiência profissional foi atualizada ;)',
    SUC_WORK_DEL = 'Prontinho! Experiência profissional removida :)',
    SUC_PROJ_SAVE = 'Item salvo em seu portfólio! Uhuul!',
    SUC_PROJ_UPDATE = 'O projeto foi atualizado ;)',
    SUC_PROJ_DEL = 'Prontinho! Projeto removido :)',
    SUC_TRIVIA_SAVE = 'Suas informações foram atualizadas!',
    SUC_GREETINGS_SAVE = 'Sua saudação e objetivo foram atualizados!',
    SUC_CONTACT_SAVE = 'Dados de contato atualizados!',
    SUC_SKILL_SAVED = 'Seu novo domínio foi registrado. Parabéns! ;)',
    SUC_SKILL_UPDATED = 'Dados atualizados!',
    SUC_SKILL_DELETED = 'A habilidade foi removida.',
    SUC_SETTINGS_SAVED = 'Seus dados foram atualizados!',
    SUC_SETTINGS_PASSWORD_SAVED = 'Senha atualizada!';

// ERROR MESSAGES
const
    ERR_UNEXISTENT_ACCOUNT = 'Hmm... não temos nenhuma conta com esse email.',
    ERR_PASSWORD_MATCH = 'Opa! As senhas não estão iguais. Por favor, verifique.',
    ERR_PASSWORD_SHORT = 'A senha precisa ter ao menos seis dígitos.',
    ERR_INVALID_EMAIL = 'Tem alguma coisa errada com esse email aí... pode conferir, por favor?',
    ERR_RESEND_EMAIL_UNEXISTENT = 'Não encontramos nenhum registro com esse e-mail. Que tal criar sua conta?',
    ERR_RESEND_EMAIL_CONFIRMED = 'Hmm... esse e-mail já foi confirmado. Tente fazer login.',
    ERR_EMAIL_MATCH = 'Os emails informados são diferentes :(',
    ERR_FORGOT_LINK_FAIL = 'Poxa, não conseguimos te enviar o email para troca de senha. Por favor, tente novamente mais tarde :(',
    ERR_ACC_CREATE_FAIL = 'Poxa, não conseguimos te enviar o email de confirmação. Por favor, tente novamente mais tarde :(',
    ERR_INVALID_CONFIRM_ID = 'Tem algo de errado com seu link. Pode conferir?',
    ERR_INVALID_AUTHENTICATION = 'Epa! Parece que o e-mail ou a senha estão errados. Por favor, tente novamente.',
    ERR_INVALID_PROFILE_IMAGE = 'Por favor, faça upload de uma imagem em .jpg ou .png.',
    ERR_INVALID_NAME = 'Preencha corretamente o seu nome completo, por favor.',
    ERR_GRAD_TITLE = 'Dá uma olhada no título da sua graduação...',
    ERR_GRAD_INST = 'Tem certeza que a instituição está correta?',
    ERR_START = 'Tem alguma coisa estranha com a data de início.',
    ERR_END = 'Verifique a data de conclusão.',
    ERR_DATE_ORDER = 'A data final deve ser depois da data inicial.',
    ERR_IMG = 'Você precisa fazer o upload de uma imagem em .jpg ou .png!',
    ERR_UNEXISTENT_GRAD = 'Não encontramos nenhuma graduação com esse identificador, mas fique à vontade pra adicionar uma nova ;)',
    ERR_WORK_POSITION = 'Dá uma olhada no seu cargo...',
    ERR_WORK_COMPANY = 'Tem certeza que a empresa está correta?',
    ERR_WORK_DESC = 'Verifique a descrição da sua experiência.',
    ERR_UNEXISTENT_WORK = 'Não encontramos nenhuma experiência com esse identificador, mas fique à vontade pra adicionar uma nova ;)',
    ERR_PROJ_NAME = 'Dá uma olhada no nome do projeto...',
    ERR_PROJ_DESC = 'Tem certeza que essa descrição está correta?',
    ERR_PROJ_TYPE = 'Esse tipo tá meio estranho...',
    ERR_PROJ_URL = 'Verifique o link do seu projeto.',
    ERR_PROJ_IMG_DIMENS = 'Faça upload de uma imagem quadrada!',
    ERR_CUSTOM_BASE_URL = 'Verifique a URL base. Lembre-se: outras pessoas vão poder usá-la!',
    ERR_CUSTOM_TYPE = 'Verifique o tipo informado. Lembre-se: outras pessoas vão poder usá-la!',
    ERR_CUSTOM_IMAGE = 'Verifique a imagem. Lembre-se: outras pessoas vão poder usá-la!',
    ERR_UNEXISTENT_PROJ = 'Não encontramos nenhum projeto com esse identificador, mas fique à vontade pra adicionar um novo ;)',
    ERR_INVALID_PERCENTAGE = 'Informe uma porcentagem válida (0-100).',
    ERR_INVALID_CATEGORY = 'Dá uma olhada na categoria selecionada...',
    ERR_INVALID_TECHNOLOGY = 'Dá uma olhada na tecnologia selecionada, por favor ;)',
    ERR_INVALID_CUSTOM_CAT = 'Tem certeza que o nome da categoria está certo?',
    ERR_INVALID_CUSTOM_TECH = 'Confirme se o nome da tecnologia tá certinho, por favor.',
    ERR_INVALID_CUSTOM_COLOR = 'Informe uma cor no formato hex!',
    ERR_UNEXISTENT_SKILL = 'Não consegui localizar esse valor...',
    ERR_INVALID_TRIVIA = 'Por favor, dá uma conferida nas suas informações ;)',
    ERR_INVALID_GREETINGS = 'Verifique seu resumo, por favor ;)',
    ERR_INVALID_GOAL = 'Confirma o objetivo, por favor ;)',
    ERR_INVALID_PHONE = 'Verifique se o telefone está correto ;)',
    ERR_INVALID_LINKEDIN = 'Tem certeza que seu LinkedIn é esse?',
    ERR_INVALID_GIT = 'Esse git tá meio estranho...',
    ERR_INVALID_SITE = 'Confirma se o site tá certinho, por favor ;)',
    ERR_INVALID_USERNAME = 'Verifique se o username está correto, por favor ;)',
    ERR_TAKEN_USERNAME = 'Esse username já tá sendo usado :/',
    ERR_OLD_PASSWORD_WRONG = 'Tem certeza que essa é sua senha atual?',
    ERR_INVALID_PALETTE = 'Ainda não temos essa paleta de cores disponível.',
    ERR_MUST_CONFIRM = 'Você precisa confirmar seu e-mail antes de acessar.',
    ERR_UNKNOWN = 'Algo de errado não está certo... Por favor, tente de novo.',
    ERR_UNEXISTENT_TECH = 'Impossible to find technology with id = ';

// INTERNAL CONSTANTS
const
    COOKIE_INDEX = 'user_identifier',
    SALT_HEAD = 's4lt_h34d',
    SALT_TAIL = 's4lt_t41l',
    CONFIRM_SALT_HEAD = 'c0nf1rm_s4lt_h34d',
    CONFIRM_SALT_TAIL = 'c0nf1rm_s4lt_t41l',
    RESET_SALT_HEAD = 'r353t_s4lt_h34d',
    ERROR_PREFIX = 'form_error_',
    SESSION_PREFIX = 'usr_session_';

// TRACKING CONSTANTS
const
    TRACKING_INDEX = 'IDX',
    TRACKING_GRADUATION = 'GRD',
    TRACKING_WORK = 'WRK',
    TRACKING_PROJ = 'PRJ',
    TRACKING_SKILLS = 'SKL',
    TRACKING_TRIVIA = 'TRV',
    TRACKING_DESC = 'DSC',
    TRACKING_CONTACT = 'CTC',
    TRACKING_404 = '404',
    TRACKING_SETTINGS = 'STN';

// LOGIN STRINGS
const
    WELCOME_MESSAGE = 'Seja bem-vindo!',
    EMAIL_HINT = 'E-mail',
    EMAIL_CONFIRM_HINT = 'Confirme o e-mail',
    PASSWORD_HINT = 'Senha',
    REMEMBER_ME = 'Mantenha-me conectado',
    LOGIN_BUTTON = 'Login',
    FACEBOOK_LOGIN = 'Login com Facebook',
    GOOGLE_LOGIN = 'Login com Google',
    FORGOT_PASSWORD = 'Esqueci minha senha',
    CREATE_ACCOUNT = 'Não tem uma conta? Crie agora!',
    RESEND_EMAIL_OPTION = 'Não recebi o e-mail de confirmação.';

// REGISTRATION STRINGS
const
    CREATE_ACCOUNT_TITLE = 'Crie sua conta!',
    CREATE_ACCOUNT_MESSAGE = 'Nesse momento precisamos apenas de um e-mail válido e uma senha de, no mínimo, seis dígitos ;)',
    REPEAT_PASSWORD_HINT = 'Confirme sua senha',
    CREATE_ACCOUNT_BUTTON = 'Bora!',
    CREATE_ACCOUNT_GOOGLE = 'Cadastrar com Google',
    CREATE_ACCOUNT_FACEBOOK = 'Cadastrar com Facebook',
    ALREADY_HAVE_ACCOUNT = 'Já tem uma conta? Faça login!',
    PERSONAL_DATA_TITLE = 'Seja muito bem-vindo!',
    PERSONAL_DATA_MESSAGE = 'Precisaremos de alguns dados bem básicos.',
    PIC_TITLE = 'Selecione uma foto onde apareça sozinho e nitidamente',
    PIC_MESSAGE = 'Se preferir, pode fazer isso outra hora :)',
    NAME_HINT = 'Qual o seu nome completo?',
    PHONE_HINT = 'Qual o seu melhor telefone para contato?',
    SETTINGS_NAME_HINT = 'Nome completo',
    SETTINGS_USERNAME_HINT = 'Username (para visualização do seu currículo online)',
    FINISH_BUTTON = 'Bora!',
    PROFILE_IMG_BASE_PATH = '/rafael-site/data/image/profile/';

// FORGOT PASSWORD STRINGS
const
    FORGOT_PASSWORD_TITLE = 'Esqueceu a senha?',
    FORGOT_PASSWORD_MESSAGE = 'Sem problemas. É só informar o e-mail usado no cadastro e em breve vamos enviar um link pra redefinir sua senha ;)',
    FORGOT_PASSWORD_BUTTON = 'Enviar link',
    NEW_PASSWORD_TITLE = 'Já sabemos quem você é ;)',
    NEW_PASSWORD_MESSAGE = 'Informe uma senha de até 6 caracteres. Ela será sua nova senha daqui pra frente.';

// RESEND EMAIL STRINGS
const
    RESEND_EMAIL_TITLE = 'Não recebeu nosso e-mail?',
    RESEND_EMAIL_MESSAGE = 'Sem problemas. É só informar o e-mail usado no cadastro e em breve faremos o reenvio ;)',
    RESEND_EMAIL_BUTTON = 'Reenviar';

// SIDEBAR STRINGS
const
    MENU_SITE_NAME = 'T.Indica',
    MENU_DASHBOARD = 'Dashboard',
    MENU_SITE_GROUP_PROFESSIONAL = 'Dados Profissionais',
    MENU_SITE_GROUP_PERSONAL = 'Dados Pessoais',
    MENU_ITEM_GRADUATION = 'Formação acadêmica',
    MENU_ITEM_PROJECTS = 'Portfólio',
    MENU_ITEM_SKILLS = 'Domínio de Tecnologias',
    MENU_ITEM_WORK = 'Experiência profissional',
    MENU_ITEM_TRIVIA = 'Informações gerais',
    MENU_ITEM_ADD = 'Novo',
    MENU_ITEM_DESC = 'Minha descrição',
    MENU_ITEM_CONTACT = 'Dados de contato';

// TOPBAR STRINGS
const
    MENU_TOP_SETTINGS = 'Minha conta',
    MENU_TOP_PREVIEW = 'Preview',
    MENU_TOP_LOGOUT = 'Sair';

// LOGOUT STRINGS
const
    LOGOUT_MODAL_TITLE = 'Já vai?',
    LOGOUT_MODAL_MESSAGE = 'Tem certeza que não tem mais nenhuma informação importante que deseja registrar?',
    LOGOUT_CANCEL = 'Faltou uma coisinha',
    LOGOUT_CONFIRM = 'Tá tudo pronto';

// HOME STRINGS
const
    CARD_SHARE_TITLE = 'Divulgação',
    CARD_SHARE_PROFILE = 'Compartilhar meu link',
    CARD_RESUME_PDF = 'Baixar meu currículo',
    CARD_ACCESS_COUNT = 'Número de acessos (total)',
    CARD_ACCESS_COUNT_WEEK = 'Número de acessos (últimos 7 dias)',
    CARD_ACCESS_COUNT_MONTH = 'Número de acessos (últimos 30 dias)',
    ACCESS_GRAPH_TITLE = 'Acessos nos últimos 12 meses',
    USER_ALERT = 'Link copiado para sua área de transferência ;)';

// FORM STRINGS
const
    DATA_BLOCK_TITLE = 'Dados',
    IMG_BLOCK_TITLE = 'Preview da imagem',
    PREVIEW_BLOCK_TITLE = 'Preview',
    DEFAULT_IMG = 'default.jpg',
    FIELD_START = 'Início em',
    FIELD_END = 'Conclusão em',
    SAVE_BUTTON = 'Registrar',
    UPDATE_BUTTON = 'Atualizar',
    TMP_IMG_BASE_PATH = '/rafael-site/data/image/tmp/',
    ICON_BASE_PATH = '/rafael-site/data/image/icons/',
    DELETE_MODAL_TITLE = 'Vai apagar?',
    DELETE_CANCEL = 'Não, deixa aí',
    DELETE_CONFIRM = 'Sim, pode apagar';

// GRADUATION STRINGS
const
    GRAD_TITLE = 'Formação Acadêmica',
    GRAD_HELPER = 'Adicione os seus cursos e graduações. Não se preocupe quanto à ordem de exibição - a gente cuida disso pra você ;)',
    GRAD_FIELD_INST = 'Instituição',
    GRAD_FIELD_TITLE = 'Título',
    GRAD_CURRENT = 'Cursando',
    GRAD_IMG_BASE_PATH = '/rafael-site/data/image/graduation/',
    DELETE_GRAD_MODAL_MESSAGE = 'Tem certeza que não deseja mais essa formação no seu currículo?';

// WORK STRINGS
const
    WORK_TITLE = 'Experiência profissional',
    WORK_HELPER = 'Adicione sua experiência profissional, detalhando suas principais atribuições. Não se preocupe quanto à ordem de exibição - a gente cuida disso pra você ;)',
    WORK_FIELD_COMP = 'Empresa',
    WORK_FIELD_DESC = 'Informe resumidamente suas principais atividades.',
    WORK_FIELD_POS = 'Cargo',
    WORK_CURRENT = 'Emprego atual',
    WORK_IMG_BASE_PATH = '/rafael-site/data/image/work/',
    DELETE_WORK_MODAL_MESSAGE = 'Tem certeza que não deseja mais essa experiência no seu currículo?';

// PORTFOLIO STRINGS
const
    PROJ_IMG_BASE_PATH = '/rafael-site/data/image/project/',
    PROJ_TITLE = 'Portfólio',
    PROJ_HELPER = 'Dê detalhes sobre o projeto e adicione os links para visualização, caso ele já esteja disponível para o público.',
    DELETE_PROJ_MODAL_MESSAGE = 'Tem certeza que não deseja mais esse projeto no seu portfólio?',
    PROJ_LINKS_TITLE = 'Adicionar link (max. 5)',
    PROJ_FIELD_NAME = 'Nome',
    PROJ_FIELD_DESC = 'Descrição',
    PROJ_DEFAULT_TYPE = 'Selecione a plataforma de distribuição';

// SKILL STRINGS
const
    SKILL_TITLE = 'Domínio de Tecnologias',
    SKILL_HELPER = 'Adicione as plataformas e linguagens que você sabe usar.',
    DELETE_SKILL_MODAL_MESSAGE = 'Tem certeza que não deseja mais essa tecnologia no seu currículo?',
    SKILL_DEF_TECH = 'Preview',
    PERCENT_FIELD = 'Domínio estimado (%)',
    SKILL_TECH_DEFAULT = 'Selecione a tecnologia',
    SKILL_BASE_COLOR = 'A773C3';

// TRIVIA STRINGS
const
    TRIVIA_TITLE = 'Informações gerais',
    TRIVIA_HELPER = 'Aqui, você pode adicionar outros detalhes relevantes para sua carreira. Sugestões: conhecimento de idiomas, hobbies, soft skills (qualidades pessoais e interpessoais)...',
    TRIVIA_FIELD = 'O que precisam saber sobre você?',
    TRIVIA_ADD = 'Adicionar informação (max. 25)';

// GREETINGS STRINGS
const
    GREETINGS_TITLE = 'Saudação e objetivo',
    GREETINGS_HINT = "Fale um pouco sobre você.\nSugerimos citar dados pessoais importantes, como idade, estado civil, perspectiva de vida/carreira e sua experiência profissional e formação acadêmica de forma resumida.\n\nEssa informação só estará disponível no seu portfolio web.",
    GOAL_HINT = "Descreva a vaga que você deseja (ex.: Desenvolvedor Java Pleno).\nObs.: essa informação só vai ser exibida no seu currículo PDF.";

// CONTACT STRINGS
const
    CONTACT_TITLE = 'Minhas redes',
    CONTACT_PHONE_PLACEHOLDER = 'Telefone/Whatsapp',
    CONTACT_IN_PLACEHOLDER = 'LinkedIn',
    CONTACT_GIT_PLACEHOLDER = 'Github | Bitbucket | Gitlab',
    CONTACT_SITE_PLACEHOLDER = 'Website';

// SETTINGS STRINGS
const
    SETTINGS_TITLE = 'Meus dados',
    OLD_PASS_HINT = 'Sua senha atual',
    CHANGE_PASS_TITLE = 'Alterar minha senha',
    NEW_PASS_HINT = 'Sua nova senha',
    NEW_PASS_CONFIRM = 'Confirme sua nova senha',
    PALETTE_LABEL = 'Selecione a paleta de cores de sua página pessoal';

// 404 MESSAGES
const
    TITLE_PAGE_404 = 'Página não encontrada :(',
    MESSAGE_404 = 'These aren\'t the droids you\'re looking for.',
    BACK_404 = 'Voltar para o dashboard';

// 403 MESSAGES
const
    TITLE_PAGE_403 = 'Acho que ia ter um Index Of aqui?',
    MESSAGE_403 = 'Shame! Shame! Shame! 🔔 🔔 🔔',
    BACK_403 = 'Voltar';