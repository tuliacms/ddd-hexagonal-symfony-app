# Uruchomienie

- `make setup`
- `make up`
  - Swagger: http://localhost:8000/api/doc
  - GraphQL Playground: http://localhost:8000/api/graphql/playground


## Namespace

- Nie zmieniałem nic, normalnie powinno być vendor/project itp, ale szkoda było mi czasu na zabawę,
  więc zostało App/ z Symfony.


## Testy

- `make unit`
- `make behat`
- Domena przetestowana za pomocą Behata i BDD. Nie robiłem wszystkich testów, a tylko te,
  które wg wymagań mają logikę biznesową. Szkoda czasu na puste testy :)
- `make integration`
- Zrobiłem naiwną implementację czyszczenia storage przed każdym testerm. W przypadku Doctrine
  użyłbym translakcji bez commita, ale tutaj miałem filesystem storage, więc musiałem troszkę wspomóc
  się samą libką i katalogami podzielonymi na środowisko.
- `make api`

## UseCase

- Nie robiłem transakcji, bo nie używam Doctrine'a, a w tym co użyłem byłoby dużo zabawy.
  Ale normalnie to cały UseCase bym zawrapował w Abstracta i tam to ogarnął. 
  Zrobiłem już coś takiego na przykład tutaj: https://github.com/tuliacms/cms/blob/master/src/Shared/Application/UseCase/AbstractTransactionalUseCase.php


## API

- `make up`
- Swagger dostępny jest pod adresem http://localhost:8000/api/doc
- Nie zrobiłem autoryzacji do API, normalnie bym użył oAuth2: https://oauth2.thephpleague.com/
- Nie zrobiłem walidacji danych wejściowych do API. Normalnie dodałbym też assercje do modeli
  Swaggera, i w kontrolerze odpalał kawałek kodu, który mi zmapuje request na obiekt tego modelu
  z walidacją asercji pól.
- W kontrolerach pominąłem walutę, nie wiem jak biznes chce to rozwiązać. Ale w domenie można ją definiować.

### GraphQL

- http://localhost:8000/api/graphql/playground

## Storage

- Zrobiłem naiwną implementację storage w plikach, zamiast w bazie danych, żeby nie używać kontenerów.
  Nie jest to zbyd dobra implementacja, ale dzięki Hexagonalowi można to łątwo podmienić na Doctrine.
