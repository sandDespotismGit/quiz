function pay () {
    var widget = new cp.CloudPayments();
       widget.pay('auth', // или 'charge'
           { //options
               publicId: 'pk_8cef82aea94ac4411ffec9597022d', //id из личного кабинета
               description: 'Оплата товаров в example.com', //назначение
               amount: 100, //сумма
               currency: 'RUB', //валюта
               accountId: 'user@example.com', //идентификатор плательщика (необязательно)
               invoiceId: '1234567', //номер заказа  (необязательно)
               email: 'user@example.com', //email плательщика (необязательно)
               skin: "mini", //дизайн виджета (необязательно)
               autoClose: 3, //время в секундах до авто-закрытия виджета (необязательный)
               data: {
                   myProp: 'myProp value'
               },
               configuration: {
                   common: {
                       successRedirectUrl: "localhost", // адреса для перенаправления 
                       failRedirectUrl: "localhost/error"        // при оплате по Tinkoff Pay
                   }
               },
               payer: { 
                   firstName: 'Alexander',
                   lastName: 'Razzhivin',
                   middleName: 'Sergeevich',
                   birth: '2003-11-05',
                   address: 'тестовый проезд дом тест',
                   street: 'Lenina',
                   city: 'MO',
                   country: 'RU',
                   phone: '89033365362',
                   postcode: '345'
               }
           },
           {
               onSuccess: function (options) { // success
                   //действие при успешной оплате
               },
               onFail: function (reason, options) { // fail
                   //действие при неуспешной оплате
               },
               onComplete: function (paymentResult, options) { //Вызывается как только виджет получает от api.cloudpayments ответ с результатом транзакции.
                   //например вызов вашей аналитики
               }
           }
       )
   };