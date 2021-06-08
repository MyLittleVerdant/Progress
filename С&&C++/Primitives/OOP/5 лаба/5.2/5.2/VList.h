#pragma once
#ifndef VLIST_H
#define VLIST_H

using namespace std;
#include <iostream>
#include "List.h"
#include <iterator>

template <typename T>
class VList;
struct node;




template <typename T> 
class VList
{
	class node 
	{

	public:
		//friend ostream& operator<< <T>(ostream& out, const VList<T>& obj);
		node* next,*prev; 
		T val; //Данные списка
		node() : next(NULL),prev(NULL) {}
		node(T data) : next(NULL),prev(NULL),val(data){}

		~node() {}

		ostream& operator << (ostream& out)
		{
		
		   out << val << endl << endl;
		   return out;

		}
	};
	node *head,*tail; 
	int count; 
public:
//	friend ostream& operator<< <T>(ostream& out, const VList<T>& obj);

	VList()
	{
		this->head = NULL;
		this->tail = NULL;
		this->count = 0;
	}

	~VList()
	{
		clear(); 
	}

	int getCount() const 
	{
		return count;
	}

	node* begin()
	{
		return head;
	}
	node* end()
	{
		return tail;
	}


	int AddToEnd(T& data)
	{
		node* to_add = new node;
		to_add->next = to_add->prev = NULL;
		to_add->val = data;
		if (head != NULL)
		{
			to_add->prev = tail;
			tail->next = to_add;
			tail = to_add;
		}
		else
		{
			to_add->prev = NULL;
			head = tail = to_add;
		}
		/*if (head == NULL) 
			head = to_add;
		else
		{
			node* current;
			for (current = head; current->next != 0; current = current->next);
			current->next = to_add;
		}*/
		count++;
		return count;
	}


	int AddToBeg(T data)
	{
		node* to_add = new node(data);
		if (head == NULL) 
			head = to_add;
		else
		{
			node* temp=head;
			head = to_add;
			to_add->next = temp;
			
		}
		count++;
		return count;
	}


	int AddAft(T data,int x)
	{
		node* to_add = new node(data);
		if (head == NULL) 
			head = to_add;
		else
		{
			node* current=head;
			node* temp;
			for (int i = 1; i < x ; i++)
				current = current->next;
			temp = current->next;
			current->next = to_add;
			to_add->next = temp;
		}
		count++;
		return count;
	}


	int del(int x) 
	{			   //Возвращает -1, если произошла ошибка
		if (x > count) return -1;
		node* to_del = head;
		if (x == 1) //Если нужно удалить первый элемент
		{
			head = head->next;
			delete to_del;
		}
		else
		{
			node* current = head;
			for (int i = 1; i < x - 1; i++)
				current = current->next;
			to_del = current->next;
			current->next = current->next->next;
			delete to_del;
		}
		count--;
		return count;
	}

	void clear() 
	{
		node* current = head;
		node* to_del = head;
		while (to_del != NULL)
		{
			current = current->next;
			delete to_del;
			to_del = current;
		}
		head = NULL;
		count = 0;
	}

	T getData(int x) const 
	{
		node* current;
		for (current = head; x > 1; x--)
			current = current->next;
		return current->val;
	}
	
	

	void Show()
	{
		node* temp = head;
		for ( int i=0;i<count;i++)
		{
			cout << temp;
			temp = temp->next;
		}
		
		
	}

	
	



};


#endif 

