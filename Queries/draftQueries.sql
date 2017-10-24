/* Contents: queries for report generation.

--elijah Johnson */


/*working quarterly draft views*/
CREATE VIEW Q1Repor AS
SELECT (select COUNT (*) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-01-01' AND ParticipantClassAttendance.date < '2017-03-31') AS Participants,
	   (select SUM (numchildren) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-01-01' AND ParticipantClassAttendance.date < '2017-03-31') AS Children;

CREATE VIEW Q2Repor AS
SELECT (select COUNT (*) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-04-01' AND ParticipantClassAttendance.date < '2017-06-30') AS Participants,
	   (select SUM (numchildren) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-04-01' AND ParticipantClassAttendance.date < '2017-06-30') AS Children;

CREATE VIEW Q3Report AS
SELECT (select COUNT (*) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-07-01' AND ParticipantClassAttendance.date < '2017-09-30') AS Participants,
	   (select SUM (numchildren) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-07-01' AND ParticipantClassAttendance.date < '2017-09-30') AS Children;

CREATE VIEW Q3Report AS
SELECT (select COUNT (*) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-10-01' AND ParticipantClassAttendance.date < '2017-12-31') AS Participants,
	   (select SUM (numchildren) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-10-01' AND ParticipantClassAttendance.date < '2017-12-31') AS Children;


/*working monthly draft views*/

CREATE VIEW janReport AS
SELECT (select COUNT (*) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-01-01' AND ParticipantClassAttendance.date < '2017-01-31') AS Participants,
	   (select SUM (numchildren) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-01-01' AND ParticipantClassAttendance.date < '2017-01-31') AS Children;

CREATE VIEW febReport AS
SELECT (select COUNT (*) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-02-01' AND ParticipantClassAttendance.date < '2017-02-28') AS Participants,
	   (select SUM (numchildren) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-02-01' AND ParticipantClassAttendance.date < '2017-02-28') AS Children;

CREATE VIEW marReport AS
SELECT (select COUNT (*) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-03-01' AND ParticipantClassAttendance.date < '2017-01-31') AS Participants,
	   (select SUM (numchildren) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-03-01' AND ParticipantClassAttendance.date < '2017-01-31') AS Children;

CREATE VIEW aprReport AS
SELECT (select COUNT (*) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-04-01' AND ParticipantClassAttendance.date < '2017-04-30') AS Participants,
	   (select SUM (numchildren) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-04-01' AND ParticipantClassAttendance.date < '2017-04-30') AS Children;

CREATE VIEW mayReport AS
SELECT (select COUNT (*) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-05-01' AND ParticipantClassAttendance.date < '2017-05-31') AS Participants,
	   (select SUM (numchildren) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-05-01' AND ParticipantClassAttendance.date < '2017-05-31') AS Children;

CREATE VIEW junReport AS
SELECT (select COUNT (*) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-06-01' AND ParticipantClassAttendance.date < '2017-06-30') AS Participants,
	   (select SUM (numchildren) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-03-01' AND ParticipantClassAttendance.date < '2017-01-31') AS Children;

CREATE VIEW julReport AS
SELECT (select COUNT (*) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-07-01' AND ParticipantClassAttendance.date < '2017-01-31') AS Participants,
	   (select SUM (numchildren) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-03-01' AND ParticipantClassAttendance.date < '2017-01-31') AS Children;
	   
CREATE VIEW augReport AS
SELECT (select COUNT (*) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-08-01' AND ParticipantClassAttendance.date < '2017-01-31') AS Participants,
	   (select SUM (numchildren) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-03-01' AND ParticipantClassAttendance.date < '2017-01-31') AS Children;
	   
CREATE VIEW sepReport AS
SELECT (select COUNT (*) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-09-01' AND ParticipantClassAttendance.date < '2017-01-31') AS Participants,
	   (select SUM (numchildren) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-03-01' AND ParticipantClassAttendance.date < '2017-01-31') AS Children;
	   
CREATE VIEW octReport AS
SELECT (select COUNT (*) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-10-01' AND ParticipantClassAttendance.date < '2017-01-31') AS Participants,
	   (select SUM (numchildren) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-03-01' AND ParticipantClassAttendance.date < '2017-01-31') AS Children;
	   
CREATE VIEW novReport AS
SELECT (select COUNT (*) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-11-01' AND ParticipantClassAttendance.date < '2017-01-31') AS Participants,
	   (select SUM (numchildren) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-03-01' AND ParticipantClassAttendance.date < '2017-01-31') AS Children;
	   
CREATE VIEW decReport AS
SELECT (select COUNT (*) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-12-01' AND ParticipantClassAttendance.date < '2017-12-31') AS Participants,
	   (select SUM (numchildren) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-12-01' AND ParticipantClassAttendance.date < '2017-12-31') AS Children;

/*working yearly draft views*/
CREATE VIEW YTDReport AS
SELECT (select COUNT (*) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-01-01' AND ParticipantClassAttendance.date < '2017-12-31') AS Participants,
	   (select SUM (numchildren) FROM ParticipantClassAttendance WHERE ParticipantClassAttendance.date >= '2017-04-01' AND ParticipantClassAttendance.date < '2017-12-31') AS Children;
