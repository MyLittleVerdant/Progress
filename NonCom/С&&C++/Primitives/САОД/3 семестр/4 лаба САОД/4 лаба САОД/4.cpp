#include <iostream>
#include <queue> 
#include <windows.h>
#include <stack>
#define BUFSIZE 1024
using namespace std;

typedef struct __STL_List_node {
	void* value;
	size_t size;
	struct __STL_List_node* next;
	struct __STL_List_node* prev;
} STL_List_node;

typedef struct __STL_List {
	STL_List_node* bp;      
	STL_List_node* lp;
	size_t size;
} STL_List;

typedef STL_List STL_Queue;
typedef STL_List_node STL_Queue_node;

struct Stack
{
	double* A;
	int l;
	int top;
};

void main() 
{
	setlocale(LC_ALL, "rus");
	
	size_t sz,sz1;
	MEMORYSTATUS stat;
	GlobalMemoryStatus(&stat);
	
	sz = stat.dwAvailPhys;//доступно пам€ти
	sz1 = sz;
	

	sz -= sizeof(STL_Queue);
	sz /= sizeof(STL_Queue_node);
	sz /= sizeof(double);
	sz =sz*1.0/1073741824;

	sz1 -= sizeof(Stack);
	sz1/= sizeof(double);

	cout << "Ќаибольший допустимый размер стека- " << sz1 << endl << "Ќаибольший допустимый размер очереди- " << sz << endl;//в байтах

}

