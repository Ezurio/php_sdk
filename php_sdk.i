/* php_sdk.i */

%module lrd_php_sdk
%{
	/* Put header files here or function declarations like below */
	extern double My_variable;
	extern int fact(int n);
	extern int my_mod(int x, int y);
	extern char *get_time();
%}

extern double My_variable;
extern int fact(int n);
extern int my_mod(int x, int y);
extern char *get_time();
