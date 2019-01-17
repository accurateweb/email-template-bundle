# email-template-bundle

### Пример конфига
```yaml
aw_email_templating:
  templating:
    loader: aw_email_templating.template.loader.doctrine
    entity: StoreBundle\Entity\Messaging\EmailTemplate
  email_templates:
    user_invitation:
      description: 'Приглашение пользователя к регистрации'
      variables:
        fio: { description: 'ФИО пользователя' }
        email: { description: 'Email пользователя' }
        phone: { description: 'Номер телефона пользователя' }
        url: { description: 'Ссылка на регистрацию' }
      defaults:
        body: |
          %%fio%%, приглашаем Вас зарегестрироваться на сайте по <a href="%%url%%">ссылке</a>
        subject: 'Приглашение к регистрации'
```
#### Описание полей
1. **templating** - основные параметры
    1. *(string)* **loader** - Загрузчик писем
    2. *(string)* **entity** - Entity писем (`implements Accurateweb\EmailTemplateBundle\Template\EmailTemplateInterface`)
    3. *(boolean)* **images_as_attachment** - Изображения из ссылок привязывать как attachments к письму
2. **email_templates** - шаблоны
    1. *{Название шаблона}*
        1. **description** - Отображаемое название шаблона
        2. **variables** - Массив переменных шаблона с описанием
        3. **defaults** - Значения по умолчанию
            1. **body** - Тело письма
            2. **subject** - Тема письма