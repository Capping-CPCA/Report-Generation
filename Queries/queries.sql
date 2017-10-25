CREATE VIEW ParticipantsEnrolled AS
(
	SELECT PA.ParticipantID, A.ZipCode, PA.race, PA.sex, PA.dateofbirth, PAC.date, PAC.firstclass, PAC.numchildren
	FROM Participants AS PA, People AS P, Forms AS F, ParticipantsFormDetails AS FD, Addresses AS A, ParticipantClassAttendance AS PAC
	WHERE P.PeopleId = PA.ParticipantID
	AND PA.ParticipantID = PAC.ParticipantID
	AND PA.ParticipantID = FD.ParticipantID
	AND FD.FormID = F.FormID
	AND F.AddressID = A.AddressID
);

--Ethnicity
SELECT DISTINCT COUNT(*) FROM ParticipantsEnrolled PE
WHERE PE.date <= '2017-11-01' --Insert end month
AND PE.date >= '2017-10-01' --Insert start month
AND PE.race = 'Native American' --Insert race 

-- Age
AND (date_part('year', AGE(PE.dateOfBirth)) > 65) --Insert < for a range

-- Gender
AND PE.sex = 'Male' --Insert sex

--Children
SELECT SUM(Result.numchildren) FROM
(
	SELECT ROW_NUMBER() OVER(PARTITION BY PE.ParticipantID ORDER BY PE.numchildren DESC) AS RN, PE.numchildren
	FROM ParticipantsEnrolled PE
	WHERE PE.date <= '2017-11-01' --Insert end month
	AND PE.date >= '2017-10-01' --Insert start month
) AS Result
WHERE RN = 1;

-- Number Of Classes
SELECT COUNT(*) FROM 
	(SELECT DISTINCT PE.date FROM ParticipantsEnrolled AS PE)
AS UniqueClassDates;

-- "Other" Zipcode mess
SELECT DISTINCT COUNT(*) FROM ParticipantsEnrolled PE
WHERE PE.zipcode <> 12501
AND PE.zipcode <> 12504
AND PE.zipcode <> 12506
AND PE.zipcode <> 12507
AND PE.zipcode <> 12508
AND PE.zipcode <> 12514
AND PE.zipcode <> 12522
AND PE.zipcode <> 12524
AND PE.zipcode <> 12531
AND PE.zipcode <> 12533
AND PE.zipcode <> 12537
AND PE.zipcode <> 12538
AND PE.zipcode <> 12540
AND PE.zipcode <> 12545
AND PE.zipcode <> 12546
AND PE.zipcode <> 12564
AND PE.zipcode <> 12567
AND PE.zipcode <> 12569
AND PE.zipcode <> 12570
AND PE.zipcode <> 12571
AND PE.zipcode <> 12572
AND PE.zipcode <> 12574
AND PE.zipcode <> 12578
AND PE.zipcode <> 12580
AND PE.zipcode <> 12581
AND PE.zipcode <> 12582
AND PE.zipcode <> 12583
AND PE.zipcode <> 12585
AND PE.zipcode <> 12590
AND PE.zipcode <> 12592
AND PE.zipcode <> 12594
AND PE.zipcode <> 12601
AND PE.zipcode <> 12602
AND PE.zipcode <> 12603
AND PE.zipcode <> 12604;
