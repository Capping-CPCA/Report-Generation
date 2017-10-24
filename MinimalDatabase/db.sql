DROP TABLE IF EXISTS Participants;
DROP TABLE IF EXISTS People;
DROP TABLE IF EXISTS ParticipantClassAttendance;
DROP TABLE IF EXISTS Forms;
DROP TABLE IF EXISTS ParticipantsFormDetails;
DROP TABLE IF EXISTS Surveys;
DROP TABLE IF EXISTS ZipCodes;

CREATE TYPE RACE AS ENUM ('African American', 'Native American', 'Pacific Islander', 'Caucasian', 'Multi-Racial', 'Other', 'Latino');
CREATE TYPE SEX AS ENUM ('Male', 'Female');

--Missing field: Middle Init
CREATE TABLE IF NOT EXISTS People (
	peopleID 	SERIAL NOT NULL UNIQUE,
	firstName	TEXT NOT NULL,
	lastName	TEXT NOT NULL,
	PRIMARY KEY(peopleID)
);

CREATE TABLE IF NOT EXISTS Participants (
	participantID	SERIAL NOT NULL UNIQUE,
	dateOfBirth	DATE NOT NULL,
	race		RACE NOT NULL,
	sex		SEX,
	PRIMARY KEY(participantID),
	FOREIGN KEY(participantID) REFERENCES People(peopleID)	
);

--Missing fields: FK topicName, FK Sitename, comments
CREATE TABLE IF NOT EXISTS ParticipantClassAttendance (
	date		TIMESTAMP,
	siteName	TEXT,
	participantID	INT,
	numChildren	INT,
	firstClass	BOOLEAN,
	PRIMARY KEY(date, participantID)
);

--Missing fields: employeeSignedDate, FK employeeID
CREATE TABLE IF NOT EXISTS Forms(
	formID		SERIAL NOT NULL UNIQUE,
	addressID	INT,
	PRIMARY KEY (formID),
	FOREIGN KEY (addressID) REFERENCES Addresses(addressID)
);

CREATE TABLE IF NOT EXISTS ParticipantsFormDetails(
	participantID		INT,
	formID			INT,
	PRIMARY KEY(participantID, formID),
	FOREIGN	KEY (participantID) REFERENCES Participants(participantID),
	FOREIGN	KEY (formID) REFERENCES Forms(formID)

);

CREATE TABLE IF NOT EXISTS Surveys(
	surveyID		INT,
	materialPresentedScore	INT,
	presTopicDiscussedScore	INT,
	presChildPerspectiveScore INT,
	presOtherParentsScore	INT,
	practiceInfoScore	INT,
	recommendScore		INT,
	suggestedFutureTopics	TEXT,
	comments		TEXT,
	PRIMARY KEY (surveyID),
	FOREIGN KEY (surveyID) REFERENCES Forms(formID)
);

--Missing type: state
CREATE TABLE IF NOT EXISTS ZipCodes(
	zipCode		INT UNIQUE,
	city		TEXT NOT NULL,
	PRIMARY KEY(zipCode)
);

--Missing fields: addressNumber, aptInfo, street
CREATE TABLE IF NOT EXISTS Addresses (
	addressID	SERIAL NOT NULL UNIQUE,
	zipCode		INT NOT NULL,
	PRIMARY KEY (addressID),
	FOREIGN KEY (zipCode) REFERENCES ZipCodes(zipCode)
);
