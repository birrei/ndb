USE [test]
GO
/****** Object:  Schema [NDB]    Script Date: 22.01.2024 15:14:36 ******/
CREATE SCHEMA [NDB]
GO
/****** Object:  Table [NDB].[Musikstueck]    Script Date: 22.01.2024 15:14:36 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [NDB].[Musikstueck](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[Name] [nvarchar](50) NULL,
	[Opus] [nvarchar](255) NULL,
	[SammlungID] [int] NULL,
	[Nummer] [int] NULL,
	[KomponistID] [int] NULL,
	[Bearbeiter] [nvarchar](50) NULL,
	[Epoche] [nvarchar](50) NULL,
	[Verwendungszweck] [nvarchar](100) NULL,
	[Gattung] [nvarchar](50) NULL,
	[Besetzung] [nvarchar](100) NULL,
PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [NDB].[Sammlung]    Script Date: 22.01.2024 15:14:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [NDB].[Sammlung](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[Name] [nvarchar](100) NULL,
	[Standort] [nvarchar](10) NULL,
	[VerlagID] [int] NULL,
	[Bestellnummer] [nvarchar](50) NULL,
	[Bemerkung] [nvarchar](150) NULL,
PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [NDB].[Verlag]    Script Date: 22.01.2024 15:14:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [NDB].[Verlag](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[Name] [nvarchar](100) NULL,
	[Bemerkung] [nvarchar](100) NULL,
PRIMARY KEY NONCLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [NDB].[Komponist]    Script Date: 22.01.2024 15:14:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [NDB].[Komponist](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[Nachname] [nvarchar](50) NULL,
	[Vorname] [nvarchar](50) NULL,
	[Geburtsdatum] [datetime2](0) NULL,
	[Sterbedatum] [datetime2](0) NULL,
	[Geburtsjahr] [nvarchar](50) NULL,
	[Sterbejahr] [nvarchar](50) NULL,
PRIMARY KEY NONCLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [NDB].[Satz]    Script Date: 22.01.2024 15:14:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [NDB].[Satz](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[MusikstueckID] [int] NULL,
	[Name] [nvarchar](100) NULL,
	[Tonart] [nvarchar](50) NULL,
	[Taktart] [nvarchar](50) NULL,
	[Tempobezeichnung] [nvarchar](50) NULL,
	[Spieldauer] [int] NULL,
	[Schwierigkeitsgrad2] [nvarchar](50) NULL,
	[Lagen] [nvarchar](50) NULL,
	[Stricharten] [nvarchar](100) NULL,
	[Erprobt] [nvarchar](250) NULL,
	[Bemerkung] [nvarchar](250) NULL,
	[Nr] [smallint] NULL,
	[Notenwerte] [nvarchar](200) NULL,
	[Schwierig] [nvarchar](50) NULL,
PRIMARY KEY NONCLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  View [NDB].[Saetze_V]    Script Date: 22.01.2024 15:14:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE   VIEW [NDB].[Saetze_V] aS 
 
SELECT 
   

	m.Name AS Musikstueck_Name, 
	m.Nummer AS Musikstueck_Nummer, 

	v.Name AS Verlag_Name, 
	sa.Name AS Sammlung_Name, 
	k.Vorname AS Komponist_Vorname, 
	k.Nachname AS Komponist_Nachname, 
	m.Besetzung as Musikstueck_Besetzung,
	st.Name as Satz_Name, 
	st.Bemerkung as Satz_Bemerkung,



	sa.ID AS SammlungID, 
	k.ID AS KomponistID,
	m.ID as MusikstueckID,
	st.ID  

   FROM 
      NDB.Musikstueck  AS m 
      LEFT join  NDB.Sammlung  AS sa on m.SammlungID = sa.ID 
      LEFT join  NDB.Komponist  AS k on m.KomponistID = k.ID 
      LEFT join  NDB.Verlag  AS v on sa.VErlagID = v.ID 
	  left join  NDB.Satz as st on st.MusikstueckID = m.ID 

GO
/****** Object:  View [NDB].[Musikstuecke_V]    Script Date: 22.01.2024 15:14:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

-- drop view NDB.Musikstuecke

CREATE   VIEW [NDB].[Musikstuecke_V]
AS 
   /*Generated by SQL Server Migration Assistant for Access version 8.1.0.*/
   SELECT 

	m.Name AS Name, 
	m.Nummer AS Nr, 

	v.Name AS Verlag, 
	sa.Name AS Sammlung, 
	--k.Vorname AS Komponist_Vorname, 
	--k.Nachname AS Komponist_Nachname, 
	CONCAT(k.Vorname, ' ', k.Nachname) as Komponist, 
	m.Besetzung,
      sa.ID AS SammlungID, 
       k.ID AS KomponistID,
	   m.ID
   FROM 
      NDB.Musikstueck  AS m 
      LEFT join  NDB.Sammlung  AS sa on m.SammlungID = sa.ID 
      LEFT join  NDB.Komponist  AS k on m.KomponistID = k.ID 
      LEFT join  NDB.Verlag  AS v on sa.VErlagID = v.ID 
   --WHERE 
   --   v.ID = sa.VerlagID AND 
   --   sa.ID = m.SammlungID AND 
   --   k.ID = m.KomponistID

-- ORDER BY m.ID DESC 

--GO

GO
/****** Object:  Table [NDB].[IMPORT_Komponistenliste]    Script Date: 22.01.2024 15:14:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [NDB].[IMPORT_Komponistenliste](
	[NAME] [varchar](250) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [NDB].[Musikstueck_tmp]    Script Date: 22.01.2024 15:14:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [NDB].[Musikstueck_tmp](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[Titel] [nvarchar](255) NULL,
	[Sammlung] [nvarchar](255) NULL,
	[Bemerkung] [nvarchar](1000) NULL,
PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [NDB].[Satz_backup]    Script Date: 22.01.2024 15:14:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [NDB].[Satz_backup](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[MusikstueckID] [int] NULL,
	[Name] [nvarchar](100) NULL,
	[Tonart] [nvarchar](50) NULL,
	[Taktart] [nvarchar](50) NULL,
	[Tempobezeichnung] [nvarchar](50) NULL,
	[Spieldauer] [int] NULL,
	[Schwierigkeitsgrad2] [nvarchar](50) NULL,
	[Lagen] [nvarchar](50) NULL,
	[RhytmBes] [nvarchar](50) NULL,
	[Stricharten] [nvarchar](100) NULL,
	[Erprobt] [nvarchar](250) NULL,
	[Uebung] [nvarchar](100) NULL,
	[Bemerkung] [nvarchar](250) NULL,
	[Nr] [smallint] NULL,
	[MelodBes] [nvarchar](100) NULL,
	[DynamBes] [nvarchar](50) NULL,
	[Notenwerte] [nvarchar](200) NULL,
	[Schwierig] [nvarchar](50) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [NDB].[Satz_backup2]    Script Date: 22.01.2024 15:14:41 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [NDB].[Satz_backup2](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[MusikstueckID] [int] NULL,
	[Name] [nvarchar](100) NULL,
	[Tonart] [nvarchar](50) NULL,
	[Taktart] [nvarchar](50) NULL,
	[Tempobezeichnung] [nvarchar](50) NULL,
	[Spieldauer] [int] NULL,
	[Schwierigkeitsgrad2] [nvarchar](50) NULL,
	[Lagen] [nvarchar](50) NULL,
	[RhytmBes] [nvarchar](50) NULL,
	[Stricharten] [nvarchar](100) NULL,
	[Erprobt] [nvarchar](250) NULL,
	[Uebung] [nvarchar](100) NULL,
	[Bemerkung] [nvarchar](250) NULL,
	[Nr] [smallint] NULL,
	[MelodBes] [nvarchar](100) NULL,
	[DynamBes] [nvarchar](50) NULL,
	[Notenwerte] [nvarchar](200) NULL,
	[Schwierig] [nvarchar](50) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [NDB].[Satz_backup3]    Script Date: 22.01.2024 15:14:41 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [NDB].[Satz_backup3](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[MusikstueckID] [int] NULL,
	[Name] [nvarchar](100) NULL,
	[Tonart] [nvarchar](50) NULL,
	[Taktart] [nvarchar](50) NULL,
	[Tempobezeichnung] [nvarchar](50) NULL,
	[Spieldauer] [int] NULL,
	[Schwierigkeitsgrad2] [nvarchar](50) NULL,
	[Lagen] [nvarchar](50) NULL,
	[RhytmBes] [nvarchar](50) NULL,
	[Stricharten] [nvarchar](100) NULL,
	[Erprobt] [nvarchar](250) NULL,
	[Uebung] [nvarchar](100) NULL,
	[Bemerkung] [nvarchar](250) NULL,
	[Nr] [smallint] NULL,
	[MelodBes] [nvarchar](100) NULL,
	[DynamBes] [nvarchar](50) NULL,
	[Notenwerte] [nvarchar](200) NULL,
	[Schwierig] [nvarchar](50) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [retired].[Komponist]    Script Date: 22.01.2024 15:14:41 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [retired].[Komponist](
	[ID] [int] NOT NULL,
	[Nachname] [nvarchar](50) NULL,
	[Vorname] [nvarchar](50) NULL,
	[Geburtsdatum] [datetime2](0) NULL,
	[Sterbedatum] [datetime2](0) NULL,
	[Geburtsjahr] [nvarchar](50) NULL,
	[Sterbejahr] [nvarchar](50) NULL,
 CONSTRAINT [Komponist$PrimaryKey] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [retired].[Musikstueck]    Script Date: 22.01.2024 15:14:41 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [retired].[Musikstueck](
	[Name] [nvarchar](50) NULL,
	[Opus] [nvarchar](255) NULL,
	[SammlungID] [int] NULL,
	[Nummer] [int] NULL,
	[Seitenzahl] [int] NULL,
	[Seitenzahl2] [int] NULL,
	[KomponistID] [int] NULL,
	[Bearbeiter] [nvarchar](50) NULL,
	[Epoche] [nvarchar](50) NULL,
	[Entstehungsjahr] [nvarchar](50) NULL,
	[Verwendungszweck] [nvarchar](100) NULL,
	[Gattung] [nvarchar](50) NULL,
	[Besetzung] [nvarchar](100) NULL,
	[Bemerkung] [nvarchar](150) NULL,
	[Hoerbeispiel] [nvarchar](255) NULL,
	[Bezeichnung] [nvarchar](100) NULL,
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[ID2] [int] NULL
) ON [PRIMARY]
GO
ALTER TABLE [NDB].[Musikstueck]  WITH CHECK ADD  CONSTRAINT [FK_KomponistID] FOREIGN KEY([KomponistID])
REFERENCES [NDB].[Komponist] ([ID])
GO
ALTER TABLE [NDB].[Musikstueck] CHECK CONSTRAINT [FK_KomponistID]
GO
ALTER TABLE [NDB].[Musikstueck]  WITH CHECK ADD  CONSTRAINT [FK_SammlungID] FOREIGN KEY([SammlungID])
REFERENCES [NDB].[Sammlung] ([ID])
GO
ALTER TABLE [NDB].[Musikstueck] CHECK CONSTRAINT [FK_SammlungID]
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'Notendatenbank.[Komponist]' , @level0type=N'SCHEMA',@level0name=N'retired', @level1type=N'TABLE',@level1name=N'Komponist'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'Notendatenbank.[Musikstueck]' , @level0type=N'SCHEMA',@level0name=N'retired', @level1type=N'TABLE',@level1name=N'Musikstueck'
GO
