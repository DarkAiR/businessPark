<?php

class m140825_063831_work_line extends CDbMigration
{
	/*public function up()
	{
	}

	public function down()
	{
		echo "m140825_063831_work_line does not support migration down.\n";
		return false;
	}*/

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->execute("
            CREATE TABLE IF NOT EXISTS `WorkLine` (
                `id`            int(11) NOT NULL AUTO_INCREMENT,
                `title`         varchar(100) NOT NULL           COMMENT 'Заголовок',
                `text`          text NOT NULL                   COMMENT 'Текст',
                `visible`       tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Показывать',
                `orderNum`      int(10) NOT NULL DEFAULT '0',
                PRIMARY KEY (`id`),
                KEY `visible` (`visible`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        $this->execute("
            INSERT INTO `WorkLine` (`orderNum`, `title`, `text`)
            VALUES
            (1, 'Выбор земельного участка', '<p>Мы предлагаем в продажу земельные участки, полностью обеспеченные инженерной инфраструктурой. С полным списком свободных участков можно ознакомиться на сайте или связаться с отделом продаж по телефону, где вас проконсультируют по любым возникшим вопросам.</p>'),
            

            (2, 'Покупка земельного участка', '<p>Оформление договора купли-продажи земельного участка. Одновременно заключается договор с Управляющей компанией на управление территорией общего пользования. УК является собственником дорог, примыканий, несет ответственность за эксплуатацию инженерных сетей Индустриального парка. Объем и перечень услуг оговаривается в договоре на управление общей территорией индустриального парка.</p>'),
            

            (3, 'Эскизное проектирование', '<p>Разработка концепции застройки участка требует достоверных исходных данных, а именно:</p>

<ol>
    <li>Эскизного проекта с учетом утвержденного проекта планировки района, красных линий и линий регулирования застройки, инженерных коммуникаций. Исходные данные предоставляет управляющая компания.</li>
    <li>Выполненного комплекса инженерных изысканий на земельном участке.</li>
    <li>Получение Градостроительного плана земельного участка.</li>
</ol>'),
            

            (4, 'Проектирование и получение Разрешения на строительство', '<p>После завершения эскизного проекта и утверждения Резидентом основных показателей, можно переходить к следующему этапу реализации проекта &ndash; проектированию объекта с учетом технических условий и утвержденных решений эскизного проекта. На данном этапе необходимо:</p>

<ol>
    <li>Получить исходно-разрешительную документацию, в том числе:
    <ul>
        <li>получение ТУ на проектирование;</li>
        <li>согласование проектной документации с надзорными органами;</li>
        <li>согласование проекта с УК &laquo;ПРО-БИЗНЕС-ПАРК&raquo;;</li>
    </ul>
    </li>
    <li>Разработка утверждаемой части проекта</li>
    <li>Получить положительное заключение экспертизы проектной документации (в случаях, установленных ст. 49 Градостроительного кодекса РФ);</li>
    <li>Получить Разрешение на строительство объекта.</li>
</ol>'),
            

            (5, 'Организация въезда на участок', '<p>Перед началом строительства, Резидент обязан организовать съезд на участок, чтобы сохранить дорожное полотно и обеспечить водоотведение поверхностных вод на период СМР, организацию стройплощадки в соответствии с требованиями нормативных документов. Собственник строит съезд по предложенной схеме своими силами или обращается за помощью в УК. В случае разрушения дорожного полотна, Резидент обязан возместить затраты на ремонт за счет собственных средств.</p>

<p>В целях установления единых требований для Резидентов в отношении состояния автодорог на территории Индустриального парка, разработан и утвержден Регламент содержания автодорог, устанавливающий общие требования и сроки устранения дефектов дорожного полотна.</p>

<p>На период строительства объекта Резидент обязан предусматривать монтаж мойки колес на выезде с участка в целях сохранения надлежащего санитарного состояния территории общего пользования.</p>'),
            

            (6, 'Подключение к сетям ресурсоснабжения', '<p>Каждому собственнику необходимо заключить &nbsp;договор на потребление коммунальных ресурсов (с энергосбытовой организацией для поставки электроэнергии, с ОВКХ для поставки питьевой воды и оказания услуг водоотведения, с поставщиком газа)</p>

<p>Для этого необходимо:</p>

<ol>
    <li>Подать заявку в ООО &laquo;УК &laquo;ПРО-БИЗНЕС-ПАРК&raquo;, запросить мощности потребляемых ресурсов в соответствии с бланком заявки. Бланк заявки можно загрузить по ссылке:_________.</li>
    <li>Получить технические условия на присоединение к сетям ресурсоснабжения;</li>
    <li>Разработать проектную документацию в соответствии с полученными техническими условиями, согласовать &nbsp;проект с балансодержателями сетей;</li>
    <li>Выполнить строительно-монтажные работы в соответствии с проектной документацией, согласованной с балансодержателями сетей;</li>
    <li>Получить акт разграничения балансовой принадлежности и эксплуатационной ответственности с балансодержателями сетей;</li>
    <li>Подать заявки в&nbsp;ресурсоснабжающие&nbsp;компании на заключение договора поставки ресурсов;</li>
    <li>Заключить договоры на ресурсоснабжение объекта.</li>
</ol>

<p>ООО &laquo;УК &laquo;ПРО-БИЗНЕС-ПАРК&raquo; готово помочь Вам в оформлении и получении договоров ресурсоснабжения Вашего участка.</p>

<p>Все интересующие вопросы Вы можете задать по телефону:&nbsp;%MAIN_PHONE%, либо по электронной почте&nbsp;<a href=\"mailto:%EMAIL%\">%EMAIL%</a>.</p>'),
            

            (7, 'Строительство', '<p>После получения разрешения на строительство, Резидент осуществляет строительно-монтажные работы в соответствии с утвержденной проектной документацией.<br />
В процессе производства работ Резидент обязан выполнять мероприятия по организации стройплощадки, установке мойки колес на выезде с участка, осуществлять технический надзор за работами привлеченных подрядных организаций.</p>

<p>В целях бесперебойной подачи ресурсов на Ваши участки, категорически запрещается самостоятельно проводить работы в районе магистральных сетей водоснабжения, водоотведения, газоснабжения, распределительных сетей электроснабжения, сетей связи.</p>

<p>Самостоятельные работы приводят к аварийным ситуациям и возможным отключениям на неопределенный срок, что негативно скажется на работе всех Резидентов Индустриального парка.</p>

<p>Затраты по восстановлению магистральных сетей в рабочее состояние, а также штрафные санкции сетевых организаций и Резидентов будут предъявлены к возмещению стороне, допустившей нарушение и создавшей аварийную ситуацию на магистральных сетях индустриального парка.</p>

<p>При необходимости выполнения работ в районе прохождения сетей, проект в обязательном порядке согласовываются с их балансодержателями и управляющей компанией, работы по раскопкам ведутся при обязательном надзоре представителя управляющей компании.</p>

<p>Для вызова представителя необходимо заблаговременно направить запрос на электронную почту <a href=\"mailto:%EMAIL%\">%EMAIL%</a>, связаться по телефону или отправить факс на номер %MAIN_PHONE%.</p>'),
            

            (8, 'Ввод объекта в эксплуатацию', '<p>По окончании строительства объекта и готовности к его вводу в эксплуатацию, Резиденту необходимо уведомить балансодержателей сетей о готовности объекта.</p>

<p>Балансодержатели сетей производят проверку выполненных работ на соответствие выданным техническим условиям.</p>

<p>При выполнении всех мероприятий, предусмотренных техническими условиями, балансодержатели выдают справки об их выполнении, необходимые для получения Разрешения на ввод объекта в эксплуатацию в соответствии с требованиям ст.55 Градостроительного кодекса РФ.</p>

<p>После получения указанного выше Разрешения, Резидент обращается в Управление федеральной службы государственной регистрации, кадастра и картографии по Свердловской области для получения кадастрового паспорта объекта и, далее, последующей государственной регистрации права на построенный объект недвижимости.&nbsp;</p>'),
            (9, 'Эксплуатация объекта', '<p>В процессе эксплуатации объекта, Резиденту необходимо определить ответственных за эксплуатацию объекта, за взаимодействие с управляющей компанией и ресурсоснабжающими организациями.</p>

<p>ООО &laquo;УК &laquo;ПРО-БИЗНЕС-ПАРК&raquo; готово при необходимости оказывать услуги по технической эксплуатации построенного объекта, содержанию территории участка Резидента, либо управлению активом Резидента, по согласованным сторонами условиям договора.</p>

<p>Управляющая компания готова оказывать всестороннее содействие Резиденту на любом этапе реализации инвестиционного проекта.</p>

<p>Любую недостающую информацию Вы можете запросить по электронной почте <a href=\"mailto:%EMAIL%\">%EMAIL%</a>, либо связаться с нами по телефону %MAIN_PHONE%.</p>')
        ");
	}

	public function safeDown()
	{
        $this->dropTable('WorkLine');
	}
}
