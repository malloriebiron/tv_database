CREATE TABLE User
( UserID INT UNSIGNED not null AUTO_INCREMENT PRIMARY KEY,
Username VARCHAR(20) not null,
Password VARCHAR(40) not null,
Email VARCHAR(50) not null UNIQUE
);
INSERT INTO User (Username, Password, Email ) Values
('billy', 'qwertyui', 'billy@world.com' );

INSERT INTO User (Username, Password, Email ) Values
('sammy', 'theedge', 'live@the.edge' );

SELECT * FROM User;

CREATE TABLE Shows
( ShowID INT UNSIGNED not null AUTO_INCREMENT PRIMARY KEY,
Title VARCHAR(50) not null,
Genre VARCHAR(50) not null,
Seasons TINYINT UNSIGNED not null
);
CREATE TABLE Actors
(ActorID INT UNSIGNED not null AUTO_INCREMENT PRIMARY KEY,
First VARCHAR(50) not null,
Last VARCHAR(50) not null
);

CREATE TABLE RelShowActor
( SAID INT UNSIGNED not null AUTO_INCREMENT PRIMARY KEY,
ShowID INT UNSIGNED not null,
ActorID INT UNSIGNED not null,
FOREIGN KEY (ShowID) REFERENCES Shows(ShowID) ON DELETE CASCADE,
FOREIGN KEY (ActorID) REFERENCES Actors(ActorID) ON DELETE CASCADE,
  CONSTRAINT unq_RelShowActor UNIQUE (ShowID,ActorID)
);

CREATE Table RelShowUser
( SUID INT UNSIGNED not null AUTO_INCREMENT PRIMARY KEY,
ShowID INT UNSIGNED not null,
UserID INT UNSIGNED not null,

FOREIGN KEY (ShowID) REFERENCES Shows(ShowID) ON DELETE CASCADE,
FOREIGN KEY (UserID) REFERENCES User(UserID) ON DELETE CASCADE,
  CONSTRAINT unq_RelShowUser UNIQUE (ShowID,UserId)
);

insert into Shows (Title, Genre, Seasons) values
( 'Stranger Things', 'Science Fiction', '1' );
select UserID from User where Username = 'billy' and Password = 'qwertyui';

select RelShowUser.ShowID
from RelShowUser
JOIN User ON (RelShowUser.UserID = User.UserID)
WHERE RelShowUser.UserID = 1;

select ShowID from RelShowUser where UserID = 1;

select Shows.Title, Shows.Genre, Shows.Seasons, User.Username SHOW_MANAGER
from Shows
LEFT JOIN RelShowUser ON (Shows.ShowID = RelShowUser.ShowID)
LEFT JOIN User ON (RelShowUser.UserId = User.UserID) 

select Actors.First, Actors.Last
from Actors
JOIN RelShowActor ON (Actors.ActorID = RelShowActor.ActorID)
WHERE RelShowActor.ShowID = 1;
