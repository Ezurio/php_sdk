/* php_sdk.i */

%module lrd_php_sdk
%include "cpointer.i"
%pointer_functions( unsigned long, ulongp )
%pointer_functions( char, charp)

%{
	#include "sdc_sdk.h"
%}

#define CONFIG_NAME_SZ  33
#define SSID_SZ         33
#define CLIENT_NAME_SZ  17
#define USER_NAME_SZ    65
#define USER_PWD_SZ     65
#define PSK_SZ          65
#define MAX_CFGS        20
#define NUM_WEP_KEYS    4
#define PDELAY_LOW      0
#define PDELAY_HIGH     7200000
#define PTIME_LOW       0
#define PTIME_HIGH      30000
#define FRAG_LOW        256
#define FRAG_HIGH       2346
#define RTS_LOW         0
#define RTS_HIGH        2347
#define AUTH_LOW        3
#define AUTH_HIGH       60
#define SCANDFSTIME_LOW 20 //ms
#define SCANDFSTIME_HIGH 500 //ms
#define MAX_CERT_PATH   65
#define CRED_CA_POS     72 //in SDCConfig userName.buffer
#define CRED_UCA_POS    72 //in SDCConfig userPwd.buffer
#define CRED_PFILE_POS  34 //in SDCConfig userPwd.buffer
#define CRED_CERT_SZ    48 //for CRED_CA and CRED_UCA
#define CRED_PFILE_SZ   32
#define USER_CERT_PW_SZ 64 //in SDCCondif userPwd.buffer
#define LRS_MAX_CHAN	  32

typedef enum _SDCERR {
	SDCERR_SUCCESS = 0,
	SDCERR_FAIL,
	SDCERR_INVALID_NAME,
	SDCERR_INVALID_CONFIG,
	SDCERR_INVALID_DELETE,
	SDCERR_POWERCYCLE_REQUIRED,
	SDCERR_INVALID_PARAMETER,
	SDCERR_INVALID_EAP_TYPE,
	SDCERR_INVALID_WEP_TYPE,
	SDCERR_INVALID_FILE,
	SDCERR_INSUFFICIENT_MEMORY,
	SDCERR_NOT_IMPLEMENTED,
	SDCERR_NO_HARDWARE,
	SDCERR_INVALID_VALUE
} SDCERR;

typedef enum _AUTH {
	AUTH_OPEN = 0,
	AUTH_SHARED,
	AUTH_NETWORK_EAP,
} AUTH;

typedef enum _EAPTYPE {
	EAP_NONE = 0,
	EAP_LEAP,
	EAP_EAPFAST,
	EAP_PEAPMSCHAP,
	EAP_PEAPGTC,
	EAP_EAPTLS,
	EAP_EAPTTLS,
	EAP_PEAPTLS,
	EAP_WAPI_CERT
} EAPTYPE;

typedef enum _POWERSAVE {
	POWERSAVE_OFF = 0,
	POWERSAVE_MAX,
	POWERSAVE_FAST,
} POWERSAVE;

typedef enum _WEPTYPE {
	WEP_OFF = 0,
	WEP_ON,
	WEP_AUTO,
	WPA_PSK,
	WPA_TKIP,
	WPA2_PSK,
	WPA2_AES,
	CCKM_TKIP,
	WEP_CKIP,
	WEP_AUTO_CKIP,
	CCKM_AES,
	WPA_PSK_AES,
	WPA_AES,
	WPA2_PSK_TKIP,
	WPA2_TKIP,
	WAPI_PSK,
	WAPI_CERT
} WEPTYPE;

typedef enum _RADIOMODE {
	RADIOMODE_B_ONLY = 0,
	RADIOMODE_BG,
	RADIOMODE_G_ONLY,
	RADIOMODE_BG_LRS,
	RADIOMODE_A_ONLY,
	RADIOMODE_ABG,
	RADIOMODE_BGA,
	RADIOMODE_ADHOC,
	RADIOMODE_GN,
	RADIOMODE_AN,
	RADIOMODE_ABGN,
	RADIOMODE_BGAN,
	RADIOMODE_BGN
} RADIOMODE;

typedef enum _TXPOWER {
	TXPOWER_MAX=0,
	TXPOWER_1=1,
	TXPOWER_5=5,
	TXPOWER_10=10,
	TXPOWER_20=20,
	TXPOWER_30=30,
	TXPOWER_50=50,
} TXPOWER;

typedef enum _BITRATE {
	BITRATE_AUTO  = 0,
	BITRATE_1     = 2,
	BITRATE_2     = 4,
	BITRATE_5_5   = 11,
	BITRATE_6     = 12,
	BITRATE_9     = 18,
	BITRATE_11    = 22,
	BITRATE_12    = 24,
	BITRATE_18    = 36,
	BITRATE_24    = 48,
	BITRATE_36    = 72,
	BITRATE_48    = 96,
	BITRATE_54    = 108,
	BITRATE_6_5   = 13,
	BITRATE_13    = 26,
	BITRATE_19_5  = 39,
	BITRATE_26    = 52,
	BITRATE_39    = 78,
	BITRATE_52    = 104,
	BITRATE_58_5  = 117,
	BITRATE_65    = 130,
	BITRATE_72    = 144,
    BITRATE_7_2   = 14,
    BITRATE_14_4  = 28,
    BITRATE_21_7  = 42,
    BITRATE_28_9  = 56,
    BITRATE_43_3  = 86,
    BITRATE_57_8  = 114
} BITRATE;

typedef enum _PREAMBLE {
	PRE_AUTO = 0,
	PRE_SHORT,
	PRE_LONG,
} PREAMBLE;

typedef enum _GSHORTSLOT {
	GSHORT_AUTO = 0,
	GSHORT_OFF,
	GSHORT_ON,
} GSHORTSLOT;

typedef enum _BT_COEXIST {
	BT_OFF  = 0,
	BT_ON,
} BT_COEXIST;

typedef enum _REGDOMAIN {
	REG_FCC   = 0,	// North America, South America, Central America, Australia, New Zealand, various parts of Asia
	REG_ETSI  = 1,	// Europe, Middle East, Africa, various parts of Asia
	REG_TELEC = 2,	// Japan
	REG_WW    = 3,	// World Wide
	REG_KCC   = 4,	// Korea
	REG_CA    = 5,	// Canada
	REG_FR    = 6,	// France
	REG_GB    = 7,	// United Kingdom
	REG_AU    = 8,	// Australia
	REG_NZ    = 9,	// New Zealand
	REG_CN    = 10,	// China
} REG_DOMAIN;

typedef enum _PING_PAYLOAD {
	PP_32    = 32,
	PP_64    = 64,
	PP_128   = 128,
	PP_256   = 256,
	PP_512   = 512,
	PP_1024  = 1024
} PING_PAYLOAD;

typedef enum _RX_DIV {
	RXDIV_MAIN = 0,
	RXDIV_AUX,
	RXDIV_START_AUX,
	RXDIV_START_MAIN,
} RX_DIV;

typedef enum _TX_DIV {
	TXDIV_MAIN = 0,
	TXDIV_AUX,
	TXDIV_ON=3,
} TX_DIV;

typedef enum _ROAM_TRIG {
	RTRIG_50 = 50,
	RTRIG_55 = 55,
	RTRIG_60 = 60,
	RTRIG_65 = 65,
	RTRIG_70 = 70,
	RTRIG_75 = 75,
	RTRIG_80 = 80,
	RTRIG_85 = 85,
	RTRIG_90 = 90,
} ROAM_TRIG;

typedef enum _ROAM_DELTA {
	RDELTA_0  = 0,
	RDELTA_5  = 5,
	RDELTA_10 = 10,
	RDELTA_15 = 15,
	RDELTA_20 = 20,
	RDELTA_25 = 25,
	RDELTA_30 = 30,
	RDELTA_35 = 35,
	RDELTA_40 = 40,
	RDELTA_45 = 45,
	RDELTA_50 = 50,
	RDELTA_55 = 55,
} ROAM_DELTA;

typedef enum _ROAM_PERIOD {
	RPERIOD_0   = 0,
	RPERIOD_5   = 5,
	RPERIOD_10  = 10,
	RPERIOD_15  = 15,
	RPERIOD_20  = 20,
	RPERIOD_25  = 25,
	RPERIOD_30  = 30,
	RPERIOD_35  = 35,
	RPERIOD_40  = 40,
	RPERIOD_45  = 45,
	RPERIOD_50  = 50,
	RPERIOD_55  = 55,
	RPERIOD_60  = 60,
} ROAM_PERIOD;

#ifndef _IGNORE_CCX_FEATURES_
typedef enum _CCX_FEATURES {
	CCX_OPTIMIZED = 0,
	CCX_FULL = 1,
	CCX_OFF = 2,
} CCX_FEATURES;
#endif

typedef enum _WEPLEN {
	WEPLEN_NOT_SET = 0,
	WEPLEN_40BIT,
	WEPLEN_128BIT,
} WEPLEN;

typedef enum _FCCTEST {
	FCCTEST_OFF  = 0,
	FCCTEST_TX   = 1,
	FCCTEST_RX   = 3,
	FCCTEST_FREQ = 2,
} FCC_TEST;

typedef enum _CARDSTATE {
	CARDSTATE_NOT_INSERTED = 0,
	CARDSTATE_NOT_ASSOCIATED,
	CARDSTATE_ASSOCIATED,
	CARDSTATE_AUTHENTICATED,
	CARDSTATE_FCCTEST,
	CARDSTATE_NOT_SDC,
	CARDSTATE_DISABLED,
	CARDSTATE_ERROR,
	CARDSTATE_AP_MODE,
} CARDSTATE;

#define RADIOTYPE_BCM_OFFSET 0x00 //CF,PE,SD10 Radios
#define RADIOTYPE_AR_OFFSET 0x100 //SD30 Radio
typedef enum _RADIOTYPE {
	RADIOTYPE_BG        = 0,
	RADIOTYPE_ABG       = 1,
	RADIOTYPE_NBG       = 2,
	RADIOTYPE_NABG      = 3,
	RADIOTYPE_AR_BG     = (RADIOTYPE_AR_OFFSET + RADIOTYPE_BG),
	RADIOTYPE_AR_ABG    = (RADIOTYPE_AR_OFFSET + RADIOTYPE_ABG),
	RADIOTYPE_AR_NBG    = (RADIOTYPE_AR_OFFSET + RADIOTYPE_NBG),
	RADIOTYPE_AR_NABG   = (RADIOTYPE_AR_OFFSET + RADIOTYPE_NABG),
	RADIOTYPE_NOT_SDC   = 0x64,
	RADIOTYPE_NOT_SDC_1 = 0x65, //reserved
} RADIOTYPE;

typedef enum _RADIOCHIPSET {
	RADIOCHIPSET_NONE     = 0,
	RADIOCHIPSET_SDC10    = 1, //BCM4318
	RADIOCHIPSET_SDC15    = 2, //BCM4322,
	RADIOCHIPSET_SDC30    = 3, //AR6002,
	RADIOCHIPSET_SDC40L   = 4, //BCM4319,
	RADIOCHIPSET_SDC40NBT = 5, //BCM4329,
	RADIOCHIPSET_SDC45    = 6, //AR6003,
} RADIOCHIPSET;


typedef enum _CERTLOCATION {
	CERT_NONE = 0,	// don't validate the server
	CERT_FILE,		// specify the filename for caCert
	CERT_FULL_STORE,	// use the entire MS-store
	CERT_IN_STORE		// use one specific cert from the MS-store, specify the cert's hash
} CERTLOCATION;

typedef enum _INTERFERENCE {
	INTER_NONE = 0,	// OFF
	INTER_NONWLAN,    // reduces CCA Tx threshold
	INTER_WLAN,	    // reduces interchannel noise
	INTER_AUTO		// automatic
} INTERFERENCE;

typedef enum _TTLS_INNER_METHOD {
	TTLS_AUTO = 0,	// uses any available EAP method
	TTLS_MSCHAPV2,
	TTLS_MSCHAP,
	TTLS_PAP,
	TTLS_CHAP,
	TTLS_EAP_MSCHAPV2,
	//TTLS_EAP_MD5,
	//TTLS_EAP_GTC,
	//TTLS_EAP_OTP,
	//TTLS_EAP_TLS
} TTLS_INNER_METHOD;

typedef enum _DFS_CHANNELS {
	DFS_OFF = 0,
	DFS_FULL,
	DFS_OPTIMIZED
} DFS_CHANNELS;

typedef enum _UAPSD {   //Bitmask enums for UAPSD
	UAPSD_AC_VO = 1,    //Access Category Voice
	UAPSD_AC_VI = 2,    //Access Category Video
	UAPSD_AC_BK = 4,    //Access Category Background
	UAPSD_AC_BE = 8     //Access Category Best Effort
} UPASD;

// or this in the length to set the XMIT key
#define XMITBIT 0x100

#pragma pack(1)

typedef struct _monitorPacket {
	unsigned long length; // add this to get to the next packet (this is the last thing set)
	unsigned long dataOffset; // add this to the frame below to get at the data of the packet
	struct _monitorPacket *previous;
	unsigned long packetLength;  //actual packet size (with header)
	unsigned long channel;
	unsigned long speed; // in 500kPs increments (11 Mbs is 22)
	unsigned long RSSI;
	unsigned long macTime;
	unsigned long CRCflag;
	unsigned long frame;
} monitorPacket;

typedef struct _monitorHeader {
	unsigned long bufSize;  //(total, includes this field, minimum 16K)
	monitorPacket  *current;
	unsigned long halted;	 //	give sniffer the ability to 'pause'
	unsigned long numPackets;
	unsigned long data;    // this is were the monitor packets get stored and wrapped around to
} monitorHeader;

typedef struct _WEPKEY {
	unsigned long  length;  //40 or 128 or 0 for not set
	unsigned char data[16]; //enough to store 128 bits
} WEPKey;

#define CRYPT_BUFFER_SIZE 120
typedef struct _CRYPT {
	unsigned long size;
	char  buffer[CRYPT_BUFFER_SIZE];
	unsigned long offset;
} CRYPT;

typedef struct _SDCConfig {
	char        configName[CONFIG_NAME_SZ];
	char        SSID[SSID_SZ];
	char        clientName[CLIENT_NAME_SZ];
	int         txPower;
	AUTH        authType;
	EAPTYPE     eapType;
	POWERSAVE   powerSave;
	WEPTYPE     wepType;
	BITRATE     bitRate;
	RADIOMODE   radioMode;
	CRYPT       userName;
	CRYPT       userPwd;
	CRYPT       PSK;
	CRYPT       WEPKeys;
} SDCConfig;

typedef struct _SDCGlobalConfig {
	unsigned long fragThreshold;
	unsigned long RTSThreshold;
	RX_DIV        RxDiversity;
	TX_DIV        TxDiversity;
	ROAM_TRIG     roamTrigger;
	ROAM_DELTA    roamDelta;
	ROAM_PERIOD   roamPeriod;
	PREAMBLE      preamble;	//not used
	GSHORTSLOT    g_shortslot;//not used
	BT_COEXIST    BTcoexist;
	PING_PAYLOAD  pingPayload;
	unsigned long pingTimeout;   //in ms
	unsigned long pingDelay;     //in ms
	unsigned long radioState;  // enabled-1, disabled-0
	unsigned long displayPasswords;  //0 no, 1 yes
	unsigned long adminOverride;
	unsigned long txMax;	  // BG radio - to account for high gain antennae--(max power out desired/19dbm) * 100
	FCC_TEST      FCCtest;      // 0 - off, 1 tx 2 frequency 3 rx
	unsigned long testChannel;  // 1-14
	BITRATE       testRate;	  //
	TXPOWER       testPower;	  //	0-100 %
	unsigned long regDomain;	  // status purposes only
	unsigned long ledUsed;      //for minimodule GPIO 0, need resistor off board to make it work
	unsigned long txTestTimeout;//in seconds--60000 (decimal) means no timeout--
	unsigned long WMEenabled;   //enable 1
	unsigned long CCXfeatures;  // enable 1 or CCX RM and AP control of TX power
	char          certPath[MAX_CERT_PATH]; // to change the path of the certificate store
	CRYPT         adminPassword;
	unsigned long bLRS;         // bit 0 = chan 1, bit 1 =chan 2, etc.
	unsigned long avgWindow;    // 2-8 (rssi moving average window)
	unsigned long probeDelay;   // 2-120 (delay before sending out probes when AP's aren't located--not config for WZC)
	unsigned long polledIRQ;    // for units that can't share IRQs nicely
	unsigned long keepAlive;	  // in cam mode how often a null packet gets sent in seconds (0 means never, 9 by default)
	unsigned long trayIcon;     // enable 1
	unsigned long aggScanTimer; // enable 1
	unsigned long authTimeout;  // in seconds, for EAP credentials, default is 8 ms
	unsigned long autoProfile;  // not implemented
	unsigned long PMKcaching;   //0 standard, 1 opportunistic key caching enabled
	unsigned long defAdhocChannel; // when no beacons found this channel is used
	unsigned long silentRunning;	 //	enables silent running mode (no active scans unless connected)
	unsigned long scanDFSTime;	//20-500 ms, default of 160 ms. Maximum time spent scanning each DFS channel during a scan.
	unsigned long suppInfo;		
#define SUPPINFO_FIPS (1U<<0)                     //bit 0 is Summit FIPS enable 
                                                  //bit 1 is reserved
#define SUPPINFO_TLS_TIME_CHECK (1U<<2)           //bit 2 is CA cert date-check 
#define SUPPINFO_WPA1_ORIGINAL_OPERATION (1U<< 3) //bit 3 is pre 2014 WPA1 operation 
	unsigned long uAPSD;          // UAPSD bitmasks
	unsigned long txMaxA;	      // A radio - to account for high gain antennae-- %
	unsigned long adminFiles;   // allows import/export of settings to file
	unsigned long DFSchannels;  //enable 1, optimized 2
	unsigned long interferenceMode;  //0 off, 1 nonWLAN, 2 WLAN, 3 auto
	unsigned long authServerType; //0 ACS (type 1), 1 SBR (type 2)
	unsigned long TTLSInnerMethod;//0 auto-EAP
	unsigned long aLRS; //bit 0 = chan 36, bit 1 =chan 40, etc
	unsigned short roamPeriodms; //Roam scan period in milliseconds, valid range 10 - 600000
	unsigned short Reserved; // future expansion of the global config......
	unsigned long Reserved1; // future expansion of the global config......
} SDCGlobalConfig;


typedef struct _SDC3rdPartyConfig {
	char        clientName[CLIENT_NAME_SZ];
	POWERSAVE   powerSave;
	int         txPower;
	BITRATE     bitRate;
	RADIOMODE   radioMode;
} SDC3rdPartyConfig;

typedef struct _CF10G_STATUS {
	CARDSTATE     cardState;
	char          configName[CONFIG_NAME_SZ];
	unsigned char client_MAC[6];
	unsigned char client_IP[4];
	char          clientName[CLIENT_NAME_SZ];
	unsigned char AP_MAC[6];
	unsigned char AP_IP[4];
	char          APName[CLIENT_NAME_SZ];
	EAPTYPE       eapType;
	unsigned long channel;
	int           rssi;
	BITRATE       bitRate;
	int           txPower;
	unsigned long driverVersion;
	RADIOTYPE     radioType;
	unsigned long DTIM;
	unsigned long beaconPeriod;
	unsigned long beaconsReceived;
} CF10G_STATUS;

typedef CF10G_STATUS SDC_STATUS, *PSDC_STATUS;

typedef struct _CONFIG_FILE_INFO {
	unsigned long   numConfigs; //no more than MAX_CFGS
	unsigned char   globalConfigPresent;
	unsigned char   thirdPartyConfigPresent;
	unsigned long   sdkVersion;
} CONFIG_FILE_INFO;

typedef struct _SDC_ALL {
	unsigned long		numConfigs; //no more than MAX_CFGS
	SDCConfig			*configs;
	SDC3rdPartyConfig	*configThirdParty;
	SDCGlobalConfig		*configGlobal;
} SDC_ALL;

typedef struct _lrs_channels {
	unsigned long chan[LRS_MAX_CHAN];
} LRD_WF_LRSChannels;

#pragma pack()

/* see lrd_sdk_pil.h for details */
typedef struct _pil_info {
	uint32_t api_version;
	char * company_name;
	char * version_string;  //optional
	char * serial_number;  // optional
	char * product_id;   // optional
	void * data;  // optional - customer use
} LRD_WF_PilInfo;

typedef struct _DHCP_LEASE {
	char interface[20];
	char address[20];
	char subnet_mask[20];
	char routers[100];
	long lease_time;
	int message_type;
	char dns_servers[100];
	char dhcp_server[20];
	char domain_name[200];
	char renew[30];
	char rebind[30];
	char expire[30];
} DHCP_LEASE;

#if 0
	SDCERR GetCurrentConfig(unsigned long *num, char *name);
	SDCERR ModifyConfig(char *name, SDCConfig *cfg);
	SDCERR GetConfig(char *name, SDCConfig *cfg);
	SDCERR DeleteConfig(char *name);
	SDCERR SetDefaultConfigValues(SDCConfig *cfg);
	SDCERR CreateConfig(SDCConfig *cfg);
	SDCERR GetNumConfigs(unsigned long *num);
	SDCERR ActivateConfig(char *name);
	SDCERR AddConfig(SDCConfig *cfg);
	SDCERR GetAllConfigs(SDCConfig *cfgs, unsigned long *num);
	SDCERR SetAllConfigs(unsigned long num, SDCConfig *cfgs);
	SDCERR LRD_WF_GetbLRSBitmask(unsigned long numChannels, LRD_WF_LRSChannels channels, unsigned long *bitmask);
	SDCERR LRD_WF_GetaLRSBitmask(unsigned long numChannels, LRD_WF_LRSChannels channels, unsigned long *bitmask);
	SDCERR LRD_WF_GetbLRSChannels(unsigned long *numChannels, LRD_WF_LRSChannels *channels, unsigned long bitmask);
	SDCERR LRD_WF_GetaLRSChannels(unsigned long *numChannels, LRD_WF_LRSChannels *channels, unsigned long bitmask);
	SDCERR GetGlobalSettings(SDCGlobalConfig *gcfg);
	SDCERR SetGlobalSettings(SDCGlobalConfig *gcfg);
#endif

SDCERR GetCurrentStatus(CF10G_STATUS *status);
SDCERR GetWifiInterfaceName(char *ifname);

#if 0
	SDCERR RadioDisable();
	SDCERR RadioEnable();
	SDCERR FirstFCCTest(FCC_TEST test, BITRATE rate, int channel,
						TXPOWER testPower, unsigned long timeout);
	SDCERR NextFCCTest(FCC_TEST test, BITRATE rate, int channel,
					   TXPOWER testPower, unsigned long timeout);
	REG_DOMAIN GetCurrentDomain();
	SDCERR updateSROM();
	SDCERR testTxData(unsigned char start, char pattern);
	SDCERR setMonitorMode(unsigned long enable, unsigned long channel, unsigned long slice, void *buffer, unsigned long bufferSize);
#endif

SDCERR GetSDKVersion(unsigned long *version);

#if 0
	SDCERR FlushConfigKeys(int configNumber);
	SDCERR FlushAllConfigKeys();

	SDCERR GetConfigFileInfo(char *filename, CONFIG_FILE_INFO *info);
	SDCERR exportSettings(char *filename, SDC_ALL *all);
	SDCERR importSettings(char *filename, SDC_ALL *all);

	SDCERR SetWEPKey(SDCConfig* cfg, int nWepKey,  WEPLEN keyLength, unsigned char* key, unsigned char txKey);
	SDCERR GetWEPKey(SDCConfig* cfg, int nWepKey,  WEPLEN* keyLength, unsigned char* key, unsigned char* txKey);
	SDCERR SetMultipleWEPKeys(SDCConfig *cfg,  int nTxKey,  WEPLEN key1Length, unsigned char * key1,
							  WEPLEN key2Length, unsigned char * key2,
							  WEPLEN key3Length, unsigned char * key3,
							  WEPLEN key4Length, unsigned char * key4);
	SDCERR GetMultipleWEPKeys(SDCConfig *cfg,  int *nTxKey, WEPLEN *key1Length, unsigned char * key1,
							  WEPLEN *key2Length, unsigned char * key2,
							  WEPLEN *key3Length, unsigned char * key3,
							  WEPLEN *key4Length, unsigned char * key4);
	SDCERR SetPSK(SDCConfig * cfg,  char * psk);
	SDCERR GetPSK(SDCConfig * cfg,  char * psk);
	SDCERR SetLEAPCred(SDCConfig * cfg,  char * username, char * password);
	SDCERR GetLEAPCred(SDCConfig * cfg,  char * username, char * password);
	SDCERR SetEAPFASTCred(SDCConfig * cfg,  char * username, char * password, char* pacfilename, char* pacpassword);
	SDCERR GetEAPFASTCred(SDCConfig * cfg,  char * username, char * password, char* pacfilename, char* pacpassword);
	SDCERR SetPEAPGTCCred(SDCConfig* cfg,  char* username, char* password, CERTLOCATION CAcertLocation, char* caCert );
	SDCERR GetPEAPGTCCred(SDCConfig* cfg,  char* username, char * password, CERTLOCATION* CAcertLocation, char* caCert );
	SDCERR SetPEAPMSCHAPCred(SDCConfig* cfg,  char* username, char* password, CERTLOCATION CAcertLocation, char* caCert );
	SDCERR GetPEAPMSCHAPCred(SDCConfig* cfg,  char* username, char * password, CERTLOCATION* CAcertLocation, char* caCert );
	SDCERR SetEAPTLSCred(SDCConfig * cfg,  char * username, char* userCert, CERTLOCATION certLocation, char* caCert);
	SDCERR GetEAPTLSCred(SDCConfig * cfg,  char * username, char* userCert, CERTLOCATION* certLocation, char* caCert);
	SDCERR SetEAPTTLSCred(SDCConfig * cfg,  char * username, char* password, CERTLOCATION certLocation, char* caCert);
	SDCERR GetEAPTTLSCred(SDCConfig * cfg,  char * username, char* password, CERTLOCATION* certLocation, char* caCert);
	SDCERR SetPEAPTLSCred(SDCConfig * cfg,  char * username, char* userCert, CERTLOCATION certLocation, char* caCert);
	SDCERR GetPEAPTLSCred(SDCConfig * cfg,  char * username, char* userCert, CERTLOCATION* certLocation, char* caCert);

	typedef struct _scanItemInfo {
		   char            ssid[40];
		   char            bssid[20];
		   int             freq;
		   int             channel;
		   int             rssi;
		   int             security;  // 0 open, 1 not open
		   EAPTYPE         eapType;   // not yet supported
		   WEPTYPE         wepType;
		   int             adHocMode; //1 enable, default 0
	} SCAN_ITEM_INFO;

	typedef struct _SDC_802_11_BSSID_LIST_EX {
		unsigned long  NumberOfItems;
		SCAN_ITEM_INFO Bssid[1];
	} SDC_802_11_BSSID_LIST_EX;

	SDCERR GetBSSIDList(SDC_802_11_BSSID_LIST_EX *list, int *numBufEntries);

	typedef enum _LRD_WF_BSSTYPE {
		INFRASTRUCTURE = 0,
		ADHOC
	} LRD_WF_BSSTYPE;

	#define LRD_WF_MAX_SSID_LEN    32
	#define LRD_WF_MAC_ADDR_LEN    6

	typedef struct _LRD_WF_SSID{
		unsigned char len;
		unsigned char val[LRD_WF_MAX_SSID_LEN];
										  // Note that the val is not a string 
										  // and can have embedded NULL and non-
										  // printable characters.  Also note
										  // that val does not have a null
										  // termination character.
	} LRD_WF_SSID;

	typedef struct _LRD_WF_SCAN_INFO_ITEM{
		int             channel;
		int             rssi;
		unsigned int    securityMask; // bit mask of WEPTYPE enums indicating 
									  // supported types
		LRD_WF_BSSTYPE  bssType;
		unsigned int    reserved;
		unsigned char   bssidMac[LRD_WF_MAC_ADDR_LEN];
		LRD_WF_SSID     ssid;
	} LRD_WF_SCAN_ITEM_INFO ;

	typedef struct _LRD_WF_BSSID_LIST{
		unsigned long  NumberOfItems;
		LRD_WF_SCAN_ITEM_INFO Bssid[1];
	} LRD_WF_BSSID_LIST;

	SDCERR LRD_WF_GetBSSIDList(LRD_WF_BSSID_LIST *list, int *numBufEntries);
	SDCERR LRD_WF_GetSSID(LRD_WF_SSID *ssid);

	typedef SDCERR (*SDC_EVENT_HANDLER) (unsigned long event_type, SDC_EVENT *event);
	SDCERR SDCRegisterForEvents( unsigned long long eventMask, SDC_EVENT_HANDLER ehandler);
	SDCERR SDCRegisteredEventsList( unsigned long long *currentMask);
	SDCERR SDCDeregisterEvents();

	SDCERR Validate_WEP_EAP_Combo(WEPTYPE wt, EAPTYPE et);
	SDCERR SetUserCertPassword(SDCConfig * cfg,  char * userPswd );
	SDCERR GetUserCertPassword(SDCConfig * cfg,  char * userPswd );
	SDCERR GetWAPICertCred(SDCConfig * cfg,  char * username, char* userCert, CERTLOCATION* certLocation, char* caCert);
	SDCERR SetWAPICertCred(SDCConfig * cfg,  char * username, char* userCert, CERTLOCATION caCertLocation, char* caCert);


	SDCERR LRD_WF_GetPilInfo(LRD_WF_PilInfo *pil_info);
	SDCERR LRD_WF_GetDHCPLease(DHCP_LEASE *dhcpLease);
	SDCERR LRD_WF_GetFipsStatus(char * current, char * nextStart);

#endif